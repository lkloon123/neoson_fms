<?php

namespace App\Models;

/**
 * App\Models\WithdrawHistory
 *
 * @property int $id
 * @property float $amount
 * @property float|null $fee
 * @property string $withdraw_address
 * @property string|null $txid
 * @property string $miner_ids
 * @property string $status
 * @property string $ip
 * @property string|null $errMsg
 * @property int $coin_id
 * @property int $farm_id
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Coin $coin
 * @property-read \App\Models\Farm $farm
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereErrMsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereFarmId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereMinerIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereTxid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawHistory whereWithdrawAddress($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class WithdrawHistory extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
