<?php

namespace App\Models;

/**
 * App\Models\Pool
 *
 * @property int $id
 * @property string $pool_name
 * @property string $pool_stratum
 * @property string|null $pool_api
 * @property string $pool_url
 * @property int $available
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string $type
 * @property string|null $ticker
 * @property string|null $algo
 * @property string|null $port
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Farm[] $farms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PoolData[] $poolDatas
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool whereAlgo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool wherePoolApi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool wherePoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool wherePoolStratum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool wherePoolUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool whereTicker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pool whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class Pool extends BaseModel
{
    public function farms()
    {
        return $this->hasMany(Farm::class);
    }

    public function poolDatas()
    {
        return $this->hasMany(PoolData::class);
    }
}
