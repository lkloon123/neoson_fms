<?php

namespace App\Api\V1\Resources;

use App\Models\Coin;
use App\Models\Pool;

/**
 * Class Farm
 *
 * @mixin \App\Models\Farm
 * */
class FarmResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'farm_name' => $this->farm_name,
            'available' => $this->available === 1,
            'current_mining_pool' => new PoolResource(Pool::find($this->pool_id)),
            'current_mining_coin' => new CoinResource(Coin::find($this->coin_id)),
        ], $this->dateTimeData());
    }
}