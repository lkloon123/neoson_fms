<?php

namespace App\Api\V1\Requests;

class CreateFarmRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'farm_name' => 'required|string|max:10|unique:farms,farm_name,NULL,id,deleted_at,NULL',
            'pool_id' => 'nullable|integer|exists:pools,id',
            'coin_id' => 'nullable|integer|exists:coins,id',
            'available' => 'nullable|boolean',
        ];
    }
}

class UpdateFarmRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'farm_name' => 'string|max:10|unique:farms,farm_name,NULL,id,deleted_at,NULL',
            'pool_id' => 'integer|exists:pools,id',
            'coin_id' => 'integer|exists:coins,id',
            'available' => 'boolean',
        ];
    }
}