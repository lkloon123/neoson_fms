<?php

namespace App\Models;

/**
 * App\Models\Software
 *
 * @property int $id
 * @property string $name
 * @property string $exe_name
 * @property string $version
 * @property string|null $github_link
 * @property string $path
 * @property string $sha256_checksum
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SoftwareUsage[] $softwareUsages
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software whereExeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software whereGithubLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software whereSha256Checksum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Software whereVersion($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class Software extends BaseModel
{
    public function softwareUsages()
    {
        return $this->hasMany(SoftwareUsage::class);
    }
}
