<?php

namespace App\Models;

/**
 * App\Models\NicehashAccount
 *
 * @property int $id
 * @property string $account_name
 * @property string $wallet_address
 * @property int $is_notification_enabled
 * @property int $should_send_notification
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereIsNotificationEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereShouldSendNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereWalletAddress($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 * @property int $is_notify_once
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAccount whereIsNotifyOnce($value)
 */
class NicehashAccount extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
