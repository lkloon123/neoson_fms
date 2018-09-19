<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Modules\Controllers;


use App\Api\V1\Controllers\MinerController;
use App\Events\StartMinerEvent;
use App\Helper\BitcoinHelper;
use App\Helper\MinerConfigGeneratorHelper;
use App\Helper\ResponseHelper;
use App\Models\Coin;
use App\Models\Farm;
use App\Models\Miner;
use App\Models\Pool;
use App\Models\PoolData;
use App\Models\Software;
use App\Models\SoftwareUsage;
use App\Models\Wallet;
use App\Models\WalletControl;
use App\Modules\Requests\GetMinerByApiTokenRequest;
use App\Modules\Requests\StartMiningRequest;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RemoteStartController extends BaseController
{
    public function setup()
    {
        $farmData = $this->getUserFarmData();
        $coinData = $this->getCoinData();

        return ResponseHelper::success([
            'farm_data' => $farmData,
            'coin_data' => $coinData,
        ]);
    }

    public function poolData($ticker)
    {
        $poolData = \DB::table('pools')
            ->join('pool_datas', 'pools.id', '=', 'pool_datas.pool_id')
            ->where('pool_datas.ticker', '=', strtoupper($ticker))
            ->get(['pools.id', 'pools.pool_name', 'pool_datas.hashrate']);

        if ($poolData->isEmpty()) {
            throw new NotFoundHttpException('no pool found for this coin');
        }

        $poolData = $poolData->sortByDesc('hashrate')->values()->all();

        return ResponseHelper::success($poolData);
    }

    public function start(StartMiningRequest $request)
    {
        $minerCount = 0;
        $allFarmIds = $request->get('farm_id');
        foreach ($allFarmIds as $farmId) {
            $selectedFarm = Farm::whereId($farmId)->firstOrFail();
            $selectedCoin = Coin::whereCoinTicker($request->get('coin_ticker'))->firstOrFail();
            $selectedPool = Pool::whereId($request->get('pool_id'))->firstOrFail();
            $selectedPoolData = PoolData::wherePoolId($selectedPool->id)->where('ticker', '=', $selectedCoin->coin_ticker)->firstOrFail();

            $bitcoinHelper = new BitcoinHelper($selectedCoin);

            foreach ($selectedFarm->miners()->get() as $miner) {
                /**
                 * @var Miner $miner
                 * @var Software $software
                 * @var Wallet[] $wallets
                 */
                if ($miner->available === 1) {
                    $wallets = $bitcoinHelper->generateWallet([$miner]);
                    if ($wallets === false) {
                        throw new HttpException(500, $bitcoinHelper->errMsg);
                    }

                    $software = SoftwareUsage::whereAlgo($selectedCoin->coin_algo)->first()->software;
                    $config = MinerConfigGeneratorHelper::ccMinerConfig(
                        SoftwareUsage::whereAlgo($selectedCoin->coin_algo)->first()->algo_setup_name,
                        $selectedPool->pool_stratum . ':' . $selectedPoolData->port,
                        $wallets[0]->wallet_address,
                        $selectedCoin->coin_ticker
                    );

                    //update db
                    $miner->update([
                        'current_mining_wallet_id' => $wallets[0]->id
                    ]);

                    broadcast(new StartMinerEvent(
                        $miner->api_token,
                        $software->name,
                        $software->exe_name,
                        $config
                    ))->toOthers();
                    $minerCount++;
                }
            }

            $selectedFarm->update([
                'coin_id' => $selectedCoin->id,
                'pool_id' => $selectedPool->id
            ]);
        }

        return ResponseHelper::success([
            'msg' => 'Successfully Started ' . $minerCount . ' miner'
        ]);
    }

    public function getMinerByApiKey(GetMinerByApiTokenRequest $request)
    {
        /** @var Miner $miner */
        $miner = Miner::whereApiToken($request->get('api_token'))
            ->available(true)
            ->first();

        if ($miner === null) {
            throw new NotFoundHttpException('Invalid Api Token');
        }

        return ResponseHelper::success([
            'id' => $miner->id,
            'miner_name' => $miner->miner_name
        ]);
    }

    private function getUserFarmData()
    {
        /** @var Collection $farms */
        //get all farm by user
        $farms = Auth::user()->farms()->get(['farms.id', 'farm_name']);

        if ($farms->isEmpty())
            throw new NotFoundHttpException('no farm found for this user');

        //check if user has miner
        //will throw a message if no miner found in this method
        //ignore the response because not using it
        (new MinerController())->index();

        return $farms;
    }

    private function getCoinData()
    {
        return Coin::whereIn('id', WalletControl::all(['coin_id']))
            ->get(['coin_ticker', 'coin_name']);
    }
}