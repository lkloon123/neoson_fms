<?php

namespace App\Api\V1\Requests;

class UpdateNotificationRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'is_read' => 'boolean|required'
        ];
    }
}