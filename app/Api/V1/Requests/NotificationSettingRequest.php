<?php

namespace App\Api\V1\Requests;


class UpdateNotificationSettingRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email_type_alert' => 'boolean|required',
            'facebook_type_alert' => 'boolean|required',
            'telegram_type_alert' => 'boolean|required',
            'web_type_alert' => 'boolean|required'
        ];
    }
}