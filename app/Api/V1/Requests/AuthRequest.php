<?php

namespace App\Api\V1\Requests;

use App\Api\V1\Rules\ValidateGoogleCaptchaRule;
use App\Helper\TwoFactorHelper;
use Auth;

class ForgotPasswordRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email'
        ];
    }
}

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'google_captcha_response' => [new ValidateGoogleCaptchaRule()],
        ];
    }
}

class ResetPasswordRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'reset_password_token' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
    }
}

class ChangePasswordRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password',
            'two_factor_code' => [
                function ($attribute, $value, $fail) {
                    TwoFactorHelper::verifyCode(Auth::user(), $value);
                }
            ]
        ];
    }
}

class RegisterRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'google_captcha_response' => ['required', new ValidateGoogleCaptchaRule()]
        ];
    }
}

class VerifyEmailRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'confirm_token' => 'required'
        ];
    }
}