<?php

namespace App\Models;

/**
 * App\Models\Monitor
 *
 * @property int $id
 * @property int $monitor_info_id
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\MonitorInfo $monitorInfo
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Monitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Monitor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Monitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Monitor whereMonitorInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Monitor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Monitor whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class Monitor extends BaseModel
{
    public function monitorInfo()
    {
        return $this->belongsTo(MonitorInfo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
