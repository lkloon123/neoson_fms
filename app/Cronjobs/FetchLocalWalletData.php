<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Cronjobs;


use App\Helper\BitcoinHelper;
use App\Models\Coin;
use App\Models\Wallet;
use App\Models\WalletControl;

class FetchLocalWalletData
{
    public function __construct()
    {
        set_time_limit(500);
        $this->fetch();
    }

    private function fetch()
    {
        $coins = Coin::whereIn('id', WalletControl::all(['coin_id']))->get();
        $wallets = Wallet::all();

        foreach ($coins as $coin) {
            $bitcoinHelper = new BitcoinHelper($coin);

            foreach ($wallets as $wallet) {
                $balance = $bitcoinHelper->getBalanceByWallet($wallet);

                if ($balance !== false) {
                    $wallet->update([
                        'balance' => $balance
                    ]);
                }
            }
        }
    }
}