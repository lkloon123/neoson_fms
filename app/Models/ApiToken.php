<?php

namespace App\Models;

use Auth;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Log;
use Token;

/**
 * App\Models\ApiToken
 *
 * @property int $id
 * @property string $token
 * @property string $type
 * @property int $available
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken confirmEmail()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken confirmWithdraw()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiToken resetPassword()
 */
class ApiToken extends BaseModel
{
    #region variables/keys
    public static $resetPassword = 'reset_password';
    public static $confirmEmail = 'confirm_email';
    public static $confirmWithdraw = 'confirm_withdraw';
    #endregion

    #region scope
    public function scopeResetPassword($query)
    {
        /** @var Builder $query */
        return $query->where('type', '=', self::$resetPassword);
    }

    public function scopeConfirmEmail($query)
    {
        /** @var Builder $query */
        return $query->where('type', '=', self::$confirmEmail);
    }

    public function scopeConfirmWithdraw($query)
    {
        /** @var Builder $query */
        return $query->where('type', '=', self::$confirmWithdraw);
    }
    #endregion

    #region attributes
    public function setTokenAttribute($value)
    {
        if ($value === null) {
            $this->attributes['token'] = null;
        } else {
            Log::debug('withdraw_api_token : ' . $value);
            $this->attributes['token'] = Hash::make($value);
        }
    }

    #endregion

    #region relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    #endregion

    #region methods
    public static function generate($type, $user = null)
    {
        $user = $user ?? Auth::user();
        $token = Token::random(40);

        self::updateOrCreate(
            [
                'type' => $type,
                'user_id' => $user->id,
                'available' => true
            ],
            ['token' => $token]
        );

        return $token;
    }

    public function validate($inputToken)
    {
        if (Hash::check($inputToken, $this->token))
            return true;

        return false;
    }

    public function use()
    {
        $this->update([
            'available' => false
        ]);
        $this->delete();
    }

    public function validateAndUse($inputToken)
    {
        if ($this->validate($inputToken)) {
            $this->use();
            return true;
        }

        return false;
    }
    #endregion
}
