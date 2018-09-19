<?php

namespace App\Api\V1\Resources;

/**
 * Class Pool
 *
 * @mixin \App\Models\Pool
 * */
class PoolResource extends BaseResource
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
            'pool_name' => $this->pool_name,
            'pool_stratum' => $this->pool_stratum,
            'pool_api' => $this->pool_api,
            'pool_url' => $this->pool_url,
            'available' => $this->available === 1,
            'type' => $this->type,
            'algo' => $this->algo,
            'ticker' => $this->ticker,
            'port' => $this->port,
        ], $this->dateTimeData());
    }
}