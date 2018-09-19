<?php

namespace App\Api\V1\Requests;

use Illuminate\Validation\Rule;

class CreatePoolRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'pool_name' => 'required|string',
            'pool_stratum' => 'required|string',
            'pool_api' => 'nullable|url',
            'pool_url' => 'required|url',
            'available' => 'nullable|boolean',
            'type' => ['string', Rule::in(['yiimp', 'oep', 'mpos'])],
            'ticker' => 'string',
            'algo' => 'string',
            'port' => 'string',
        ];
    }
}

class UpdatePoolRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'pool_name' => 'string',
            'pool_stratum' => 'string',
            'pool_api' => 'url',
            'pool_url' => 'url',
            'available' => 'boolean',
            'type' => ['string', Rule::in(['yiimp', 'oep', 'mpos'])],
            'ticker' => 'string',
            'algo' => 'string',
            'port' => 'string',
        ];
    }
}