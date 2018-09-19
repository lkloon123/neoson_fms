<?php

namespace App\Modules\Requests;

class CreateBotMessageRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'type' => 'required',
            'message' => 'required|string',
            'target' => 'array'
        ];
    }
}