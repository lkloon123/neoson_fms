<?php

namespace App\Models;

/**
 * App\Models\MonitorInfo
 *
 * @property int $id
 * @property string $wallet_address
 * @property float|null $coin_balance
 * @property int $available
 * @property int $coin_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Coin $coin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Monitor[] $monitors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonitorInfo whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonitorInfo whereCoinBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonitorInfo whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonitorInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonitorInfo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonitorInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonitorInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonitorInfo whereWalletAddress($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class MonitorInfo extends BaseModel
{
    public function monitors()
    {
        return $this->hasMany(Monitor::class);
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'monitors');
    }
}
