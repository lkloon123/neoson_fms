<?php

namespace App\Models;

/**
 * App\Models\MarketData
 *
 * @property int $id
 * @property string $ticker
 * @property float $price
 * @property float $volume
 * @property float|null $ask
 * @property float|null $bid
 * @property int $market_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Models\Market $market
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel available($available)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData whereAsk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData whereBid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData whereTicker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MarketData whereVolume($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 */
class MarketData extends BaseModel
{
    public function market()
    {
        return $this->belongsTo(Market::class);
    }
}
