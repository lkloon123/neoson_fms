<?php

namespace App\Api\V1\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Coin;
use App\Models\Farm;
use App\Models\Miner;
use App\Models\Wallet;
use Auth;
use Bouncer;
use Denpa\Bitcoin\Client as BitcoinClient;
use Illuminate\Http\Request;
use stdClass;

class WalletController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farms = Auth::user()->farms;
        $coins = Coin::all();
        $uniqueId = 1;
        $result = [];

        foreach ($coins as $coin) {
            foreach ($farms as $farm) {
                /** @var Farm $farm */
                $miners = $farm->miners()->get();
                $farmBalance = 0;
                $tempObj = new stdClass();
                $minerObj = [];

                foreach ($miners as $miner) {
                    /** @var Miner $miner */
                    $wallets = $miner->wallets()->where('coin_id', '=', $coin->id)->get();
                    $walletBalance = 0;
                    foreach ($wallets as $wallet) {
                        /** @var Wallet $wallet */
                        if ($wallet->reserve_balance !== null) {
                            $walletBalance += ($wallet->balance - $wallet->reserve_balance);
                        } else {
                            $walletBalance += $wallet->balance;
                        }
                    }

                    $farmBalance += $walletBalance;

                    $minerObj[] = array_add($miner->only(['id', 'miner_name']), 'miner_balance', (float)BitcoinClient::toFixed($walletBalance));
                }

                @$tempObj->id = $uniqueId++;
                @$tempObj->coin = $coin->only(['id', 'coin_name', 'coin_ticker']);
                @$tempObj->farm = $farm->only(['id', 'farm_name']);
                @$tempObj->miner = $minerObj;
                @$tempObj->farm_balance = BitcoinClient::toFixed($farmBalance);
                @$tempObj->canWithdraw = Bouncer::can('farm_' . $farm->id . '_withdraw');

                $result[] = $tempObj;
            }
        }

        return ResponseHelper::success($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(wallet $wallet)
    {
        //
    }
}
