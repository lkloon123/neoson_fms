<?php

namespace App\Api\V1\Requests;

use Dingo\Api\Http\FormRequest;

class CreateCoinRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'coin_name' => 'required|string',
            'coin_ticker' => 'required|string',
            'coin_algo' => 'required|string',
            'isMineable' => 'nullable|boolean',
            'explorer_link' => 'nullable|url',
            'explorer_type' => 'nullable|string',
            'available' => 'nullable|boolean',
        ];
    }
}

class UpdateCoinRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'coin_name' => 'string',
            'coin_ticker' => 'string',
            'coin_algo' => 'string',
            'isMineable' => 'boolean',
            'explorer_link' => 'url',
            'explorer_type' => 'string',
            'available' => 'boolean',
        ];
    }
}