<?php

namespace App\Models;

/**
 * App\Models\Farm
 *
 * @property int $id
 * @property string $farm_name
 * @property int $available
 * @property int|null $pool_id
 * @property int|null $coin_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Coin|null $coin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FarmUser[] $farmUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Miner[] $miners
 * @property-read \App\Models\Pool|null $pool
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WithdrawHistory[] $withdrawHistories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Farm whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Farm whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Farm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Farm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Farm whereFarmName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Farm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Farm wherePoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Farm whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class Farm extends BaseModel
{
    public function farmUsers()
    {
        return $this->hasMany(FarmUser::class);
    }

    public function miners()
    {
        return $this->hasMany(Miner::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'farm_users');
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function withdrawHistories()
    {
        return $this->hasMany(WithdrawHistory::class);
    }
}
