<?php

namespace App\Models;

/**
 * App\Models\Miner
 *
 * @property int $id
 * @property string $miner_name
 * @property int $available
 * @property int|null $current_mining_wallet_id
 * @property int $farm_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string $api_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Farm $farm
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wallet[] $wallets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereCurrentMiningWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereFarmId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereMinerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MinerSummary[] $minerSummaries
 * @property int $is_notification_enabled
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereIsNotificationEnabled($value)
 * @property \Carbon\Carbon|null $notification_sent_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Miner whereNotificationSentTimestamp($value)
 */
class Miner extends BaseModel
{
    protected $dates = ['notification_sent_timestamp'];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function minerSummaries()
    {
        return $this->hasMany(MinerSummary::class);
    }
}
