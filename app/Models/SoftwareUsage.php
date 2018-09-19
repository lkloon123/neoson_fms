<?php

namespace App\Models;

/**
 * App\Models\SoftwareUsage
 *
 * @property int $id
 * @property string $algo
 * @property string $algo_setup_name
 * @property int|null $software_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Software|null $software
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoftwareUsage whereAlgo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoftwareUsage whereAlgoSetupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoftwareUsage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoftwareUsage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoftwareUsage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoftwareUsage whereSoftwareId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SoftwareUsage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class SoftwareUsage extends BaseModel
{
    public function software()
    {
        return $this->belongsTo(Software::class);
    }
}
