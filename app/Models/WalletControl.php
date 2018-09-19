<?php

namespace App\Models;

use Crypt;

/**
 * App\Models\WalletControl
 *
 * @property int $id
 * @property string $rpc_user
 * @property string $rpc_password
 * @property string $rpc_port
 * @property string $rpc_host
 * @property int $available
 * @property int $coin_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Coin $coin
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereRpcHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereRpcPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereRpcPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereRpcUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletControl whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class WalletControl extends BaseModel
{
    #region attributes
    public function setRpcUserAttribute($value)
    {
        if ($value === null) {
            $this->attributes['rpc_user'] = null;
        } else {
            $this->attributes['rpc_user'] = Crypt::encryptString($value);
        }
    }

    public function getRpcUserAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        return Crypt::decryptString($value);
    }

    public function setRpcPasswordAttribute($value)
    {
        if ($value === null) {
            $this->attributes['rpc_password'] = null;
        } else {
            $this->attributes['rpc_password'] = Crypt::encryptString($value);
        }
    }

    public function getRpcPasswordAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        return Crypt::decryptString($value);
    }

    public function setRpcPortAttribute($value)
    {
        if ($value === null) {
            $this->attributes['rpc_port'] = null;
        } else {
            $this->attributes['rpc_port'] = Crypt::encrypt($value);
        }
    }

    public function getRpcPortAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        return Crypt::decrypt($value);
    }

    public function setRpcHostAttribute($value)
    {
        if ($value === null) {
            $this->attributes['rpc_host'] = null;
        } else {
            $this->attributes['rpc_host'] = Crypt::encryptString($value);
        }
    }

    public function getRpcHostAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        return Crypt::decryptString($value);
    }

    #endregion

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
