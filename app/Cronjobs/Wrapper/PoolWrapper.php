<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Cronjobs\Wrapper;


use App\Models\Pool;
use App\Models\PoolData;

class PoolWrapper
{
    public static function loadYiimp(Pool $pool, $poolDetail)
    {
        foreach ($poolDetail as $ticker => $data) {
            PoolData::updateOrCreate(['ticker' => $pool->ticker ?: $ticker, 'pool_id' => $pool->id], [
                'ticker' => $pool->ticker ?: $ticker,
                'algo' => $data->algo,
                'port' => (int)$data->port,
                'height' => $data->height,
                'workers' => $data->workers,
                'hashrate' => $data->hashrate,
                'estimate' => $data->estimate,
                'lastblock' => $data->lastblock,
                'timesincelast' => $data->timesincelast,
                'pool_id' => $pool->id,
            ]);
        }
    }

    public static function loadOep(Pool $pool, $poolDetail)
    {
        PoolData::updateOrCreate(['ticker' => $pool->ticker, 'pool_id' => $pool->id], [
            'ticker' => $pool->ticker,
            'algo' => $pool->algo,
            'port' => $pool->port,
            'workers' => $poolDetail->minersTotal ?: null,
            'hashrate' => $poolDetail->hashrate,
            'pool_id' => $pool->id,
        ]);
    }

    public static function loadMpos(Pool $pool, $poolDetail)
    {
        PoolData::updateOrCreate(['ticker' => $pool->ticker, 'pool_id' => $pool->id], [
            'ticker' => $pool->ticker,
            'algo' => $pool->algo,
            'port' => $pool->port,
            'workers' => $poolDetail->workers ?: null,
            'hashrate' => $poolDetail->hashrate,
            'lastblock' => $poolDetail->last_block ?: null,
            'pool_id' => $pool->id,
        ]);
    }
}