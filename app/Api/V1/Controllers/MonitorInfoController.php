<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Resources\CoinResource;
use App\Helper\ResponseHelper;
use App\Models\Coin;
use App\Models\MarketData;
use App\Models\MonitorInfo;
use Auth;
use Denpa\Bitcoin\Client as BitcoinClient;
use Illuminate\Http\Request;

class MonitorInfoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $monitorInfoList = Auth::user()->monitorInfos;
        $coinList = Coin::all();
        $result = [];

        //calculate balance
        foreach ($coinList as $coin) {
            $selectedMonitorInfos = $monitorInfoList->whereIn('coin_id', $coin->id);

            if ($selectedMonitorInfos->isNotEmpty()) {
                $tmp = new \stdClass();
                $tmp->coin = new CoinResource($coin);
                $tmp->balance = 0;
                $tmp->balance_in_btc = 0;

                foreach ($selectedMonitorInfos as $monitorInfo) {
                    $tmp->balance += $monitorInfo->coin_balance;
                }

                $tmp->balance = BitcoinClient::toFixed($tmp->balance);

                //calculate balance in btc
                $marketPrice = MarketData::whereTicker($coin->coin_ticker)->get()->median('price');
                $tmp->market_price = BitcoinClient::toFixed($marketPrice);
                $tmp->balance_in_btc = BitcoinClient::toFixed($marketPrice * $tmp->balance);

                $result[] = $tmp;
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
     * @param  \App\MonitorInfo $monitorInfo
     * @return \Illuminate\Http\Response
     */
    public function show(MonitorInfo $monitorInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MonitorInfo $monitorInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(MonitorInfo $monitorInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\MonitorInfo $monitorInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonitorInfo $monitorInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MonitorInfo $monitorInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonitorInfo $monitorInfo)
    {
        //
    }
}
