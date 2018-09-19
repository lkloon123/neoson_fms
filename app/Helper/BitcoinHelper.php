<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Helper;


use App\Api\V1\Resources\CoinResource;
use App\Models\Coin;
use App\Models\Miner;
use App\Models\Wallet;
use Carbon\Carbon;
use Denpa\Bitcoin\Client as BitcoinClient;
use Denpa\Bitcoin\Exceptions\BitcoindException;
use Denpa\Bitcoin\Exceptions\ClientException;
use GuzzleHttp\Client as GuzzleClient;
use Log;
use Webpatser\Uuid\Uuid;

class BitcoinHelper
{
    public $errMsg = 'wallet offline';
    private $bitcoinClient = false;
    private $coin;

    public function __construct($coin)
    {
        $this->coin = $coin;
        $this->constructBitcoinClient($coin);
    }

    public function getStatus()
    {
        $status = [
            'coin' => new CoinResource($this->coin),
            'version' => 'wallet offline',
            'connection' => 'wallet offline',
        ];

        try {
            if ($this->bitcoinClient !== false) {
                $cmd = $this->bitcoinClient->getInfo();

                $status['version'] = $this->formatWalletVersion($cmd->get('version'));
                $status['connection'] = $cmd->get('connections');
            }
        } catch (ClientException $e) {
            $this->errMsg = $e->getMessage();
        } catch (BitcoindException $e) {
            $this->errMsg = $e->getMessage();
        }

        $status['updated_at'] = Carbon::now()->format(config('app.datetime_format'));
        return $status;
    }

    public function getBalanceByWallet(Wallet $wallet)
    {
        if ($this->bitcoinClient === false) {
            return false;
        }

        try {
            return BitcoinClient::toFixed($this
                ->getUnspentList($wallet->wallet_address)
                ->sum('*.amount'));
        } catch (ClientException $e) {
            $this->errMsg = $e->getMessage();
            return false;
        } catch (BitcoindException $e) {
            $this->errMsg = $e->getMessage();
            return false;
        }
    }

    public function generateWallet(array $miners)
    {
        if ($this->bitcoinClient === false) {
            return false;
        }

        $walletList = [];
        /** @var Miner $miner */
        foreach ($miners as $miner) {
            $tempWallet = new Wallet([
                'coin_id' => $this->coin->id,
                'miner_id' => $miner->id,
                'wallet_key' => Uuid::generate()->string
            ]);

            try {
                //generate address
                $tempWallet->wallet_address = $this->bitcoinClient->getAccountAddress($tempWallet->wallet_key)->get();

                //store private key
                $tempWallet->priv_key = $this->bitcoinClient->dumpPrivKey($tempWallet->wallet_address)->get();

                if ($tempWallet->save()) {
                    $walletList[] = $tempWallet;
                }
            } catch (ClientException $e) {
                return false;
            } catch (BitcoindException $e) {
                $this->errMsg = $e->getMessage();
                return false;
            }
        }

        return $walletList;
    }

    public function getFee($withdrawAmount, array $minerIds, $updateBalance = false)
    {
        if ($this->bitcoinClient === false) {
            return false;
        }

        $wallets = Wallet::all()
            ->whereIn('miner_id', $minerIds)
            ->whereIn('coin_id', $this->coin->id)
            ->values()
            ->all();

        try {
            return $this->calculateFee($withdrawAmount, $wallets, $updateBalance);
        } catch (ClientException $e) {
            return false;
        } catch (BitcoindException $e) {
            $this->errMsg = $e->getMessage();
            return false;
        }
    }

    public function withdraw($withdrawAmount, $farmId, array $minerIds, $withdrawAddress)
    {
        if ($this->bitcoinClient === false) {
            return false;
        }

        $wallets = Wallet::all()
            ->whereIn('miner_id', $minerIds)
            ->whereIn('coin_id', $this->coin->id)
            ->values()
            ->all();

        $fee = $this->getFee($withdrawAmount, $minerIds);

        try {
            return $this->prepareTransaction($withdrawAmount, $fee, $withdrawAddress, $wallets);
        } catch (ClientException $e) {
            return false;
        } catch (BitcoindException $e) {
            $this->errMsg = $e->getMessage();
            return false;
        }

    }

    private function prepareTransaction($withdrawAmount, $fee, $withdrawAddress, $wallets)
    {
        $totalUnspentAmount = 0;
        $unspentTxList = [];
        $leftOverAddress = null;

        foreach ($wallets as $wallet) {
            /** @var Wallet $wallet */
            $unspentList = $this->getUnspentList($wallet->wallet_address);

            foreach ($unspentList->get() as $unspent) {
                if ($totalUnspentAmount + $fee < $withdrawAmount) {
                    $unspentTxList[] = ['txid' => $unspent['txid'], 'vout' => $unspent['vout']];
                    $leftOverAddress = $unspent['address'];
                    $totalUnspentAmount += $unspent['amount'];
                }
            }
        }

        //change amount
        $leftOverAmount = $totalUnspentAmount - $withdrawAmount;

        if ($leftOverAmount < 0) {
            $this->errMsg = 'not enough balance';
            return false;
        }

        //build outputs
        $outputs = [];
        $outputs += [$withdrawAddress => (float)BitcoinClient::toFixed($withdrawAmount - $fee)];
        if ($leftOverAmount > 0) {
            $outputs += [$leftOverAddress => (float)BitcoinClient::toFixed($leftOverAmount)];
        }

        try {
            //generate raw transactions
            return $this->generateTransaction($unspentTxList, $outputs);
        } catch (ClientException $e) {
            return false;
        } catch (BitcoindException $e) {
            $this->errMsg = $e->getMessage();
            return false;
        }
    }

    private function calculateFee($withdrawAmount, $wallets, $updateBalance)
    {
        $withdrawAmount = BitcoinClient::toFixed($withdrawAmount);
        $txCount = 0;
        $firstTxByte = 261;
        $perTxByte = 148;
        $feePerByte = 0.00000010001;
        $defaultFee = 0.00010001;
        $fee = $defaultFee;
        $totalUnspentAmount = 0;
        $totalBalance = 0;

        foreach ($wallets as $wallet) {
            /** @var Wallet $wallet */
            $unspentList = $this->getUnspentList($wallet->wallet_address);
            $totalBalance += $this->getBalanceByWallet($wallet);

            if ($updateBalance === true) {
                $wallet->reserve_balance = 0;
            }
            foreach ($unspentList->get() as $unspent) {
                if ($totalUnspentAmount + $fee < $withdrawAmount) {
                    $totalUnspentAmount += $unspent['amount'];
                    $txCount++;
                    //calculate transaction size
                    $byte = ($txCount - 1) * $perTxByte + $firstTxByte;
                    //calculate fee
                    $fee = $byte * $feePerByte;
                    if ($fee < $defaultFee) {
                        $fee = $defaultFee;
                    }
                    if ($updateBalance === true) {
                        $wallet->reserve_balance += $unspent['amount'];
                    }
                }
            }
        }

        $totalBalance = BitcoinClient::toFixed($totalBalance);

        if ($totalBalance < $withdrawAmount) {
            $this->errMsg = 'not enough balance';
            return false;
        }

        //update balance
        if ($updateBalance === true) {
            foreach ($wallets as $wallet) {
                $wallet->save();
            }
        }

        return BitcoinClient::toFixed($fee);
    }

    private function constructBitcoinClient($coin)
    {
        /** @var Coin $coin */
        if ($coin === null) {
            $this->bitcoinClient = false;
            return false;
        }

        $walletControl = $coin->walletControls()
            ->available(true)
            ->first();

        if ($walletControl === null) {
            $this->bitcoinClient = false;
            return false;
        }

        $this->bitcoinClient = new BitcoinClient([
            'host' => $walletControl->rpc_host,
            'port' => $walletControl->rpc_port,
            'user' => $walletControl->rpc_user,
            'pass' => $walletControl->rpc_password,
        ]);

        $guzzleConfig = $this->bitcoinClient->getConfig();
        $guzzleConfig['timeout'] = 3.14;
        $this->bitcoinClient->setClient(new GuzzleClient($guzzleConfig));

        return true;
    }

    private function getUnspentList($address)
    {
        return $this->bitcoinClient->listUnspent(10, 99999999, [$address]);
    }

    private function formatWalletVersion($versionString)
    {
        $version = substr($versionString, 0, 20);
        if (is_numeric($version)) {
            $decver = sprintf('%08d', 0 + $version);
            $version = (int)substr($decver, 0, 2) . '.' . (int)substr($decver, 2, 2) .
                '.' . (int)substr($decver, 4, 2);
            if ((int)substr($decver, 6))
                $version .= '.' . (int)substr($decver, 6);
        } else {
            $version = ltrim($version, 'v');
        }
        return $version;
    }

    private function generateTransaction($unspentTxList, $outputs)
    {
        Log::debug('unspent-list: ' . json_encode($unspentTxList));
        Log::debug('outputs: ' . json_encode($outputs));
        $rawTxId = $this->bitcoinClient->createRawTransaction($unspentTxList, $outputs);
        $sig_res = $this->bitcoinClient->signRawTransaction($rawTxId->get());
        $txId = $this->bitcoinClient->sendRawTransaction($sig_res('hex')->get());

        return $txId->get();
    }
}