<?php

namespace App\Api\V1\Resources;

/**
 * Class Coin
 *
 * @mixin \App\Models\Coin
 * */
class CoinResource extends BaseResource
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
            'coin_name' => $this->coin_name,
            'coin_ticker' => $this->coin_ticker,
            'coin_algo' => $this->coin_algo,
            'isMineable' => $this->isMineable === 1,
            'explorer_link' => $this->explorer_link,
            'explorer_type' => $this->explorer_type,
            'available' => $this->available === 1,
        ], $this->dateTimeData());
    }
}