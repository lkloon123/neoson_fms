<?php

namespace App\Models;

/**
 * App\Models\NotificationSetting
 *
 * @property int $id
 * @property int $email_type_alert
 * @property int $telegram_type_alert
 * @property int $facebook_type_alert
 * @property int $web_type_alert
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereEmailTypeAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereFacebookTypeAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereTelegramTypeAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereWebTypeAlert($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class NotificationSetting extends BaseModel
{
    public function user()
    {
        $this->belongsTo(User::class);
    }

    public static function default()
    {
        return new self([
            'email_type_alert' => 1,
            'telegram_type_alert' => 1,
            'facebook_type_alert' => 1,
            'web_type_alert' => 1,
        ]);
    }
}
