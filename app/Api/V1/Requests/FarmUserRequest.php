<?php

namespace App\Api\V1\Requests;

class UpdateFarmUserRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'farm_user_list' => 'required'
        ];
    }
}