<?php

namespace App\Models;

/**
 * App\Models\SupportTicketMessage
 *
 * @property int $id
 * @property string $message
 * @property int $post_by_user_id
 * @property int $support_ticket_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\User $postBy
 * @property-read \App\Models\SupportTicket $supportTicket
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicketMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicketMessage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicketMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicketMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicketMessage wherePostByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicketMessage whereSupportTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SupportTicketMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class SupportTicketMessage extends BaseModel
{
    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    public function postBy()
    {
        return $this->belongsTo(User::class, 'post_by_user_id');
    }
}
