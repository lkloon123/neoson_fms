<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Cronjobs;


use App\Models\MinerSummary;
use Carbon\Carbon;

class TruncateMinerSummaries
{
    public function __construct()
    {
        set_time_limit(500);
        MinerSummary::where('created_at', '<', Carbon::now()->subMinute(15))
            ->each(function ($item) {
                $item->forceDelete();
            });
    }
}