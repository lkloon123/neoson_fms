<?php

namespace App\Jobs;

use App\Helper\BitcoinHelper;
use App\Models\Miner;
use App\Models\WithdrawHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWithdrawJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $withdrawItem;

    /**
     * Create a new job instance.
     *
     * @param WithdrawHistory $withdrawItem
     */
    public function __construct(WithdrawHistory $withdrawItem)
    {
        $this->withdrawItem = $withdrawItem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bitcoinHelper = new BitcoinHelper($this->withdrawItem->coin);

        $txId = $bitcoinHelper->withdraw(
            $this->withdrawItem->amount,
            $this->withdrawItem->farm_id,
            json_decode($this->withdrawItem->miner_ids, true),
            $this->withdrawItem->withdraw_address
        );

        if ($txId === false) {
            $this->withdrawItem->update([
                'status' => 'error',
                'errMsg' => $bitcoinHelper->errMsg,
            ]);
            foreach (json_decode($this->withdrawItem->miner_ids) as $minerId) {
                $wallets = Miner::find($minerId)->wallets;
                foreach ($wallets as $wallet) {
                    $wallet->update([
                        'reserve_balance' => null
                    ]);
                }
            }
        } else {
            $this->withdrawItem->update([
                'status' => 'completed',
                'txid' => $txId
            ]);
        }
    }
}
