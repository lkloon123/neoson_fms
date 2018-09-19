<?php

namespace App\Models;

/**
 * App\Models\PoolData
 *
 * @property int $id
 * @property string $ticker
 * @property string $algo
 * @property int $port
 * @property int|null $height
 * @property int|null $workers
 * @property string|null $hashrate
 * @property string|null $estimate
 * @property int|null $lastblock
 * @property int|null $timesincelast
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property int $pool_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Pool $pool
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereAlgo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereHashrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereLastblock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData wherePoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereTicker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereTimesincelast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PoolData whereWorkers($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class PoolData extends BaseModel
{
    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
