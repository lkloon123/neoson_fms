<?php

namespace App\Models;

/**
 * App\Models\SupportTicket
 *
 * @property int $id
 * @property string $subject
 * @property string $status
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SupportTicketMessage[] $supportTicketMessages
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicket whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicket whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicket whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class SupportTicket extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supportTicketMessages()
    {
        return $this->hasMany(SupportTicketMessage::class);
    }
}
