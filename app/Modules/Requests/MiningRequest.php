<?php

namespace App\Modules\Requests;

use App\Helper\TwoFactorHelper;
use App\Models\Coin;
use App\Models\WalletControl;
use Auth;
use Illuminate\Database\Eloquent\Collection;

class StartMiningRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'farm_id' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    /** @var Collection $farms */
                    $farms = Auth::user()->farms()->get(['farms.id']);
                    if ($farms->isEmpty()) {
                        return $fail('no farm found for this user');
                    }

                    foreach ($value as $item) {
                        if (!$farms->contains('id', $item)) {
                            return $fail('Farm ID ' . $item . ' not found');
                        }
                    }
                }
            ],
            'coin_ticker' => [
                'required',
                function ($attribute, $value, $fail) {
                    $coins = Coin::whereIn('id', WalletControl::all(['coin_id']))
                        ->get(['coins.coin_ticker']);

                    if (!$coins->contains('coin_ticker', strtoupper($value))) {
                        return $fail($attribute . ' not found');
                    }
                }
            ],
            'pool_id' => 'required|exists:pools,id',
            'twofa_code' => [
                'required',
                function ($attribute, $value, $fail) {
                    TwoFactorHelper::verifyCode(Auth::guard()->user(), $value);
                }
            ]
        ];
    }
}

class GetMinerByApiTokenRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'api_token' => 'required'
        ];
    }
}