<?php

namespace App\Models;

use Crypt;

/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property string $wallet_address
 * @property int $available
 * @property int $coin_id
 * @property int $miner_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string|null $priv_key
 * @property string|null $wallet_key
 * @property float|null $balance
 * @property float|null $reserve_balance
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Coin $coin
 * @property-read \App\Models\Miner $miner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereMinerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet wherePrivKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereReserveBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereWalletAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereWalletKey($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class Wallet extends BaseModel
{
    public function miner()
    {
        return $this->belongsTo(Miner::class);
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    public function setPrivKeyAttribute($value)
    {
        if ($value === null) {
            $this->attributes['priv_key'] = null;
        } else {
            $this->attributes['priv_key'] = Crypt::encryptString($value);
        }
    }

    public function getPrivKeyAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        return Crypt::decryptString($value);
    }
}
