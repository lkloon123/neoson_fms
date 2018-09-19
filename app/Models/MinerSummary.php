<?php

namespace App\Models;

/**
 * App\Models\MinerSummary
 *
 * @property int $id
 * @property string $algo
 * @property int $gpu_count
 * @property string $hashrate
 * @property int $accepted_hash
 * @property int $rejected_hash
 * @property int $up_time
 * @property int $miner_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Miner $miner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereAcceptedHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereAlgo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereGpuCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereHashrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereMinerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereRejectedHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereUpTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MinerSummary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 * @mixin \Eloquent
 */
class MinerSummary extends BaseModel
{
    public function miner()
    {
        return $this->belongsTo(Miner::class);
    }
}
