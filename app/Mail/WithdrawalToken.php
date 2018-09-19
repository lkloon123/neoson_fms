<?php

namespace App\Mail;

use App\Models\Coin;
use App\Models\Farm;
use App\Models\User;
use App\Modules\Requests\RequestWithdrawalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawalToken extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $userConfirmWithdrawalLink;
    public $userRejectWithdrawalLink;
    public $farmName;
    public $withdrawAddress;
    public $withdrawAmount;
    public $coinTicker;
    public $userIp;
    public $withdrawId;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $token
     * @param RequestWithdrawalRequest $request
     */
    public function __construct(User $user, $token, RequestWithdrawalRequest $request, $userIp, $withdrawHistory)
    {
        $this->user = $user;
        $this->userConfirmWithdrawalLink = config('app.url') . 'wallet/withdraw/process?a=true&e=' . $user->email . '&t=' . $token;
        $this->userRejectWithdrawalLink = config('app.url') . 'wallet/withdraw/process?a=false&e=' . $user->email . '&t=' . $token;
        $this->farmName = Farm::whereId($request->get('farm_id'))->first()->farm_name;
        $this->withdrawAddress = $request->get('withdraw_address');
        $this->withdrawAmount = $request->get('withdraw_amount');
        $this->coinTicker = Coin::whereId($request->get('coin_id'))->first()->coin_ticker;
        $this->userIp = $userIp;
        $this->withdrawId = $withdrawHistory->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('NeoSon Crypto Withdrawal Confirmation')
            ->view('emails.module.withdraw_confirmation');
    }
}
