<?php

namespace App\Models;

/**
 * App\Models\Bot
 *
 * @property int $id
 * @property string|null $fb_id
 * @property string|null $tele_id
 * @property int $available
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereFbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereTeleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class Bot extends BaseModel
{
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
