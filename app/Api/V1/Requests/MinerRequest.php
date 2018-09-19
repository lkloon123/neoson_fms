<?php

namespace App\Api\V1\Requests;

class CreateMinerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'miner_name' => 'required|string',
            'farm_id' => 'required|integer|exists:farms,id',
            'available' => 'nullable|boolean',
        ];
    }
}

class UpdateMinerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'miner_name' => 'string',
            'farm_id' => 'integer|exists:farms,id',
            'current_mining_wallet_id' => 'integer|exists:wallets,id',
            'is_notification_enabled' => 'boolean',
            'available' => 'boolean',
        ];
    }
}