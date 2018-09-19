<?php

namespace App\Api\V1\Requests;

use App\Api\V1\Rules\ValidateGoogleCaptchaRule;
use Illuminate\Validation\Rule;

class CreateSupportTicketRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'subject' => 'string|required',
            'message' => 'string|required',
            'google_captcha_response' => ['required', new ValidateGoogleCaptchaRule()],
        ];
    }
}

class UpdateSupportTicketRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'status' => ['string', 'required', Rule::in(['reopened', 'closed', 'user replied', 'staff replied'])],
        ];
    }
}
