<?php

namespace App\Modules\Resources;

use App\Api\V1\Resources\UserResource;

/**
 * Class WithdrawHistory
 *
 * @mixin \App\Models\WithdrawHistory
 * */
class WithdrawHistoryResource extends BaseResource
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
            'amount' => (float)$this->amount,
            'fee' => (float)$this->fee ?: null,
            'withdraw_address' => $this->withdraw_address,
            'txid' => $this->txid ?: null,
            'status' => $this->status,
            'ip' => $this->ip,
            'coin' => $this->coin->only(['id', 'coin_name', 'coin_ticker']),
            'farm' => $this->farm->only(['id', 'farm_name']),
            'by' => new UserResource($this->user),
        ], $this->dateTimeData());
    }
}