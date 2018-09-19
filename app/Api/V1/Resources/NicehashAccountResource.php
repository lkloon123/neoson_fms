<?php

namespace App\Api\V1\Resources;

/**
 * Class NicehashAccount
 *
 * @mixin \App\Models\NicehashAccount
 * */
class NicehashAccountResource extends BaseResource
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
            'account_name' => $this->account_name,
            'wallet_address' => $this->wallet_address,
            'is_notification_enabled' => $this->is_notification_enabled === 1,
            'is_notify_once' => $this->is_notify_once === 1
        ], $this->dateTimeData());
    }
}