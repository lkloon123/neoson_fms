<?php

namespace App\Api\V1\Requests;

class UpdateWalletControlRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'rpc_user' => 'string',
            'rpc_password' => 'string',
            'rpc_port' => 'integer',
            'rpc_host' => 'string',
        ];
    }
}

class CreateWalletControlRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'rpc_user' => 'string|required',
            'rpc_password' => 'string|required',
            'rpc_port' => 'integer|required',
            'rpc_host' => 'string|required',
            'coin_id' => 'integer|required|exists:coins,id'
        ];
    }
}