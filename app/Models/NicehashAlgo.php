<?php

namespace App\Models;

/**
 * App\Models\NicehashAlgo
 *
 * @property int $id
 * @property string $name
 * @property int $algo_id
 * @property int $port
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAlgo whereAlgoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAlgo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAlgo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAlgo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAlgo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAlgo wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NicehashAlgo whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class NicehashAlgo extends BaseModel
{
    //
}
