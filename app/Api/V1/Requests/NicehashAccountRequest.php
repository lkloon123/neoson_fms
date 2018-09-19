<?php

namespace App\Api\V1\Requests;

class CreateNicehashAccountRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'account_name' => 'required|string|max:10|unique:nicehash_accounts,account_name,NULL,id,deleted_at,NULL',
            'wallet_address' => 'required|string',
            'is_notification_enabled' => 'required|boolean',
        ];
    }
}

class UpdateNicehashAccountRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'account_name' => 'string|max:10|unique:nicehash_accounts,account_name,NULL,id,deleted_at,NULL',
            'wallet_address' => 'string',
            'is_notification_enabled' => 'boolean',
            'is_notify_once' => 'boolean',
        ];
    }
}