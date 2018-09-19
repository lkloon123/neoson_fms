<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Modules\Controllers;


use App\Helper\BitcoinHelper;
use App\Helper\ResponseHelper;
use App\Jobs\ProcessWithdrawJob;
use App\Mail\WithdrawalToken;
use App\Models\ApiToken;
use App\Models\Coin;
use App\Models\Farm;
use App\Models\Miner;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WithdrawHistory;
use App\Modules\Requests\GetFeeRequest;
use App\Modules\Requests\ProcessWithdrawalRequest;
use App\Modules\Requests\RequestWithdrawalRequest;
use Auth;
use Bouncer;
use Denpa\Bitcoin\Client as BitcoinClient;
use Mail;
use Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class WithdrawalController extends BaseController
{
    public function getFee(GetFeeRequest $request, $updateBalance = false)
    {
        //check permission
        if (Bouncer::cannot('farm_' . $request->get('farm_id') . '_withdraw')) {
            throw new AccessDeniedHttpException('you are not allow to withdraw from this farm');
        }

        if ($request->get('withdraw_amount') <= 0) {
            throw new BadRequestHttpException('withdraw amount cannot be less then 0');
        }

        $bitcoinHelper = new BitcoinHelper(Coin::find($request->get('coin_id')));

        $fee = $bitcoinHelper->getFee(
            $request->get('withdraw_amount'),
            $request->get('miner_ids'),
            $updateBalance
        );

        if ($fee === false) {
            throw new HttpException(500, $bitcoinHelper->errMsg);
        }

        return ResponseHelper::success([
            'fee' => $fee,
            'nettAmount' => BitcoinClient::toFixed($request->get('withdraw_amount') - $fee),
        ]);
    }

    public function requestWithdrawal(RequestWithdrawalRequest $request)
    {
        //check permission
        if (Bouncer::cannot('farm_' . $request->get('farm_id') . '_withdraw')) {
            throw new AccessDeniedHttpException('you are not allow to withdraw from this farm');
        }

        if ($request->get('withdraw_amount') <= 0) {
            throw new BadRequestHttpException('withdraw amount cannot be less then 0');
        }

        $oldRecord = Auth::user()
            ->apiTokens
            ->where('type', '=', 'confirm_withdraw')
            ->isNotEmpty();

        if ($oldRecord === true) {
            $oldWithdrawHistory = Auth::user()
                ->withdrawHistories
                ->where('status', '=', 'pending email')
                ->first();

            if ($oldWithdrawHistory !== null) {
                $oldWithdrawHistory->update([
                    'status' => 'rejected'
                ]);
                foreach (json_decode($oldWithdrawHistory->miner_ids) as $minerId) {
                    $wallets = Miner::find($minerId)->wallets;
                    foreach ($wallets as $wallet) {
                        $wallet->update([
                            'reserve_balance' => null
                        ]);
                    }
                }
            }
        }

        $token = ApiToken::generate('confirm_withdraw');

        $fee = $this->getFee($request, true)->getOriginalContent()['data']['fee'];

        $withdrawHistory = WithdrawHistory::create([
            'fee' => $fee,
            'amount' => $request->get('withdraw_amount'),
            'withdraw_address' => $request->get('withdraw_address'),
            'miner_ids' => json_encode($request->get('miner_ids')),
            'ip' => Request::ip(),
            'coin_id' => Coin::whereId($request->get('coin_id'))->first()->id,
            'farm_id' => Farm::whereId($request->get('farm_id'))->first()->id,
            'user_id' => Auth::user()->id,
        ]);

        Mail::to(\Auth::user())
            ->send(
                new WithdrawalToken(
                    Auth::user(),
                    $token,
                    $request,
                    Request::ip(),
                    $withdrawHistory
                )
            );

        return ResponseHelper::success([
            'msg' => 'withdrawal request created, please check your email for confirmation'
        ], 201);
    }

    public function processWithdrawal(ProcessWithdrawalRequest $request)
    {
        $user = User::whereEmail($request->get('email'))->first();
        $this->validateUser($user);

        /** @var ApiToken $apiToken */
        $apiToken = $user->apiTokens
            ->where('type', '=', 'confirm_withdraw')
            ->sortByDesc('updated_at')
            ->first();

        if ($apiToken === null) {
            throw new AccessDeniedHttpException('outdated request, please request new withdrawal');
        }

        if (!$apiToken->validateAndUse($request->get('confirm_token'))) {
            throw new UnauthorizedHttpException('', 'unauthorized token');
        }

        $withdrawHistory = $user
            ->withdrawHistories()
            ->where('status', '=', 'pending email')
            ->orderByDesc('updated_at')
            ->first();

        if ($withdrawHistory === null) {
            throw new HttpException(500, 'outdated request, please request new withdrawal');
        }

        if ($request->get('confirm_action') === false) {
            $minerIds = json_decode($withdrawHistory->miner_ids, true);
            foreach ($minerIds as $minerId) {
                Wallet::whereMinerId($minerId)
                    ->where('coin_id', '=', $withdrawHistory->coin->id)
                    ->update([
                        'reserve_balance' => null
                    ]);
            }

            $withdrawHistory->update([
                'status' => 'rejected'
            ]);

            return ResponseHelper::success([
                'msg' => 'withdrawal id ' . $withdrawHistory->id . ' has been rejected'
            ]);
        }

        $withdrawHistory->update([
            'status' => 'processing'
        ]);

        ProcessWithdrawJob::dispatch($withdrawHistory);

        return ResponseHelper::success([
            'msg' => 'withdraw has been confirmed and will be processed in few min'
        ]);
    }
}