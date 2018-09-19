<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreateWalletControlRequest;
use App\Api\V1\Requests\UpdateWalletControlRequest;
use App\Helper\BitcoinHelper;
use App\Helper\ResponseHelper;
use App\Models\Coin;
use App\Models\WalletControl;
use Bouncer;
use Cache;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WalletControlController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coins = Coin::all();
        $result = [];

        foreach ($coins as $coin) {
            $bitcoinHelper = new BitcoinHelper($coin);

            $tmp = Cache::remember(BitcoinHelper::class . $coin->id . '_getStatus', config('cache.duration'),
                function () use ($bitcoinHelper) {
                    return $bitcoinHelper->getStatus();
                });

            $result[] = array_add($tmp, 'id', $coin->id);
        }

        return ResponseHelper::success($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateWalletControlRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateWalletControlRequest $request)
    {
        //check permission
        if (Bouncer::cannot('wallet_control_create')) {
            throw new AccessDeniedHttpException('you are not allow to create wallet control');
        }

        $requestData = $request->only([
            'rpc_user',
            'rpc_password',
            'rpc_port',
            'rpc_host',
            'coin_id'
        ]);

        $walletControl = WalletControl::create($requestData);
        $this->validateModel($walletControl);

        return ResponseHelper::success([
            'msg' => 'wallet control created',
            'id' => $walletControl->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $coinTicker
     * @return \Illuminate\Http\Response
     */
    public function show($coinTicker)
    {
        $coin = Coin::whereCoinTicker(strtoupper($coinTicker))->first();

        if ($coin === null) {
            throw new NotFoundHttpException('coin ticker ' . $coinTicker . ' not found');
        }

        $bitcoinHelper = new BitcoinHelper($coin);

        $result = Cache::remember(BitcoinHelper::class . $coin->id . '_getStatus', config('cache.duration'),
            function () use ($bitcoinHelper) {
                return $bitcoinHelper->getStatus();
            });

        return ResponseHelper::success($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $walletControlId
     * @param UpdateWalletControlRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($walletControlId, UpdateWalletControlRequest $request)
    {
        //check permission
        if (Bouncer::cannot('wallet_control_update')) {
            throw new AccessDeniedHttpException('you are not allow to update wallet control');
        }

        $requestData = $request->only([
            'rpc_user',
            'rpc_password',
            'rpc_port',
            'rpc_host'
        ]);

        if (empty($requestData)) {
            return ResponseHelper::success([
                'msg' => 'nothing updated'
            ]);
        }

        //find for wallet control
        $walletControl = WalletControl::find($walletControlId);

        if ($walletControl === null) {
            throw new NotFoundHttpException('walet control id ' . $walletControlId . ' not found');
        }

        foreach ($requestData as $key => $value) {
            $walletControl->$key = $value;
        }

        $this->saveModel($walletControl);

        return ResponseHelper::success([
            'msg' => 'wallet control updated',
            'id' => $walletControlId
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $walletControlId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete($walletControlId)
    {
        //check permission
        if (Bouncer::cannot('wallet_control_' . $walletControlId . '_delete')) {
            throw new AccessDeniedHttpException('you are not allow to delete this wallet control');
        }

        $walletControl = WalletControl::find($walletControlId);
        if ($walletControl === null)
            throw new NotFoundHttpException('wallet control id ' . $walletControlId . ' not found');

        $walletControl->delete();

        return ResponseHelper::success([
            'msg' => 'wallet control id ' . $walletControl->id . ' deleted'
        ]);
    }

    public function getNotExistCoinList()
    {
        $coins = Coin::all()
            ->whereNotIn('id', WalletControl::all()->pluck('coin_id'))
            ->values()
            ->all();

        return ResponseHelper::success($coins);
    }
}
