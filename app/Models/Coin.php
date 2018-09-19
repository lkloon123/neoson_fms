<?php

namespace App\Models;

/**
 * App\Models\Coin
 *
 * @property int $id
 * @property string $coin_name
 * @property string $coin_ticker
 * @property string|null $coin_algo
 * @property int $isMineable
 * @property string|null $explorer_link
 * @property string|null $explorer_type
 * @property int $available
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Farm[] $farms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MonitorInfo[] $monitorInfos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WalletControl[] $walletControls
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wallet[] $wallets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WithdrawHistory[] $withdrawHistories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereCoinAlgo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereCoinName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereCoinTicker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereExplorerLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereExplorerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereIsMineable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class Coin extends BaseModel
{
    public function farms()
    {
        return $this->hasMany(Farm::class);
    }

    public function walletControls()
    {
        return $this->hasMany(WalletControl::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function monitorInfos()
    {
        return $this->hasMany(MonitorInfo::class);
    }

    public function withdrawHistories()
    {
        return $this->hasMany(WithdrawHistory::class);
    }
}
