<?php

namespace App\Models;

use Crypt;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $secret_2fa
 * @property int|null $timestamp_2fa
 * @property string|null $temp_2fa
 * @property string|null $remember_token
 * @property int|null $bot_id
 * @property int $available
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property int $login_attempt
 * @property string|null $profile_img
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Ability[] $abilities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ApiToken[] $apiTokens
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Bot|null $bot
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FarmUser[] $farmUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Farm[] $farms
 * @property mixed $secret2fa
 * @property mixed $temp2fa
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MonitorInfo[] $monitorInfos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Monitor[] $monitors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NicehashAccount[] $nicehashAccounts
 * @property-read \App\Models\NotificationSetting $notificationSetting
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Silber\Bouncer\Database\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SupportTicketMessage[] $supportTicketMessages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SupportTicket[] $supportTickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WithdrawHistory[] $withdrawHistories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIs($role)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsAll($role)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsNot($role)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLoginAttempt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereProfileImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSecret2fa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereTemp2fa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereTimestamp2fa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class User extends BaseModel implements JWTSubject, AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable, HasRolesAndAbilities;

    protected $hidden = [
        'password', 'remember_token', 'secret_2fa', 'pivot',
    ];

    protected $auditExclude = [
        'password', 'remember_token', 'secret_2fa', 'temp_2fa', 'timeStamp_2fa'
    ];

    #region attributes
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setSecret2faAttribute($value)
    {
        if ($value === null) {
            $this->attributes['secret_2fa'] = null;
        } else {
            $this->attributes['secret_2fa'] = Crypt::encryptString($value);
        }
    }

    public function getSecret2faAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        return Crypt::decryptString($value);
    }

    public function setTemp2faAttribute($value)
    {
        if ($value === null) {
            $this->attributes['temp_2fa'] = null;
        } else {
            $this->attributes['temp_2fa'] = Crypt::encryptString($value);
        }
    }

    public function getTemp2faAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        return Crypt::decryptString($value);
    }

    #endregion

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    #region relationship
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function monitors()
    {
        return $this->hasMany(Monitor::class);
    }

    public function monitorInfos()
    {
        return $this->belongsToMany(MonitorInfo::class, 'monitors');
    }

    public function farmUsers()
    {
        return $this->hasMany(FarmUser::class);
    }

    public function farms()
    {
        return $this->belongsToMany(Farm::class, 'farm_users');
    }

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function supportTicketMessages()
    {
        return $this->hasMany(SupportTicketMessage::class, 'post_by_user_id');
    }

    public function apiTokens()
    {
        return $this->hasMany(ApiToken::class);
    }

    public function notificationSetting()
    {
        return $this->hasOne(NotificationSetting::class);
    }

    public function withdrawHistories()
    {
        return $this->hasMany(WithdrawHistory::class);
    }

    public function nicehashAccounts()
    {
        return $this->hasMany(NicehashAccount::class);
    }
    #endregion
}
