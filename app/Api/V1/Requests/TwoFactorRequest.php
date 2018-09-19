<?php

namespace App\Api\V1\Requests;

class SaveTwoFactorRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'two_factor_code' => 'required'
        ];
    }
}
