<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Api\V1\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Coin;
use App\Models\Miner;
use Auth;

class DashboardController extends BaseController
{
    public function index()
    {
        $farms = Auth::user()->farms;
        if ($farms->isNotEmpty()) {
            $totalFarm = $farms->count();
            $totalMiner = Miner::whereIn('farm_id', $farms->pluck('id'))->count();
        } else {
            $totalFarm = 0;
            $totalMiner = 0;
        }

        $totalNicehashAcount = Auth::user()->nicehashAccounts->count();

        $monitorInfos = Auth::user()->monitorInfos;
        $totalMonitorCoin = Coin::whereIn('id', $monitorInfos->pluck('coin_id'))->count();

        return ResponseHelper::success([
            'total_farm' => $totalFarm,
            'total_miner' => $totalMiner,
            'total_nicehash_account' => $totalNicehashAcount,
            'total_monitoring_coin' => $totalMonitorCoin
        ]);
    }
}