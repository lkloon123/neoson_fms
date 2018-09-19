<?php

namespace App\Modules\Requests;

use App\Helper\TwoFactorHelper;
use Auth;

class GetFeeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'coin_id' => 'required',
            'withdraw_amount' => 'required',
            'miner_ids' => 'required|array',
            'farm_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $farms = Auth::user()->farms()->get(['farms.id']);
                    if ($farms->isEmpty()) {
                        return $fail('no farm found for this user');
                    }

                    if (!$farms->contains('id', $value)) {
                        return $fail('Farm ID ' . $value . ' not found');
                    }
                }
            ],
        ];
    }
}

class RequestWithdrawalRequest extends GetFeeRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['withdraw_address'] = 'required';
        $rules['twofa_code'] = [
            'required',
            function ($attribute, $value, $fail) {
                TwoFactorHelper::verifyCode(Auth::user(), $value);
            }
        ];

        return $rules;
    }
}

class ProcessWithdrawalRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'confirm_token' => 'required',
            'confirm_action' => 'required|boolean'
        ];
    }
}