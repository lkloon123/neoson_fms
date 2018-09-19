<?php

namespace App\Api\V1\Resources;

use App\Models\Farm;
use App\Models\Wallet;

/**
 * Class Miner
 *
 * @mixin \App\Models\Miner
 * */
class MinerResource extends BaseResource
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
            'miner_name' => $this->miner_name,
            'current_mining_wallet' => Wallet::find($this->wallet_id),
            'belongs_to_farm' => new FarmResource(Farm::find($this->farm_id)),
            'api_token' => $this->api_token,
            'is_notification_enabled' => $this->is_notification_enabled === 1,
            'available' => $this->available === 1,
        ], $this->dateTimeData());
    }
}