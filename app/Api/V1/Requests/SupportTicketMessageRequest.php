<?php

namespace App\Api\V1\Requests;

use Dingo\Api\Http\FormRequest;

class CreateSupportTicketMessageRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'message' => 'string|required',
        ];
    }
}
