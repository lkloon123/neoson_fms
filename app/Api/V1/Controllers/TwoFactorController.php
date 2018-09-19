<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Api\V1\Controllers;


use App\Api\V1\Requests\SaveTwoFactorRequest;
use App\Helper\ResponseHelper;
use App\Helper\TwoFactorHelper;
use App\Models\User;
use Auth;
use Config;
use PragmaRX\Google2FA\Google2FA;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TwoFactorController extends BaseController
{
    private $userNotLoggedMsg = 'user not logged in';
    private $notEnableMsg = 'two factor authentication is not enabled';
    private $enabledMsg = 'two factor authentication is enabled';
    private $retrySetupMsg = 'secret code not generated, please retry two factor authencation setup';

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \PragmaRX\Google2FA\Exceptions\InsecureCallException
     */
    public function setup()
    {
        User::disableAuditing();
        $user = Auth::user();

        if ($user === null) {
            throw new UnauthorizedHttpException('', $this->userNotLoggedMsg);
        }

        if ($user->secret_2fa !== null) {
            throw new AccessDeniedHttpException($this->enabledMsg);
        }

        $google2fa = new Google2FA();
        $twoFaSecret = $google2fa->generateSecretKey();
        $user->temp_2fa = $twoFaSecret;
        $user->save();

        $google2fa->setAllowInsecureCallToGoogleApis(true);
        $qr = $google2fa->getQRCodeGoogleUrl(
            Config::get('app.name'),
            $user->email,
            $twoFaSecret
        );

        return ResponseHelper::success([
            'secret' => $twoFaSecret,
            'qr' => $qr,
        ]);
    }

    public function save(SaveTwoFactorRequest $request)
    {
        $twoFaCode = $request->get('two_factor_code');

        //check if user have temp 2fa
        $user = Auth::user();

        if ($user === null) {
            throw new UnauthorizedHttpException('', $this->userNotLoggedMsg);
        }

        if ($user->temp_2fa === null) {
            throw new AccessDeniedHttpException($this->retrySetupMsg);
        }

        //check if code correct
        if (!TwoFactorHelper::verifyCode($user, $twoFaCode)) {
            throw new HttpException(500);
        }

        TwoFactorHelper::enableSave($user);

        return ResponseHelper::success([
            'msg' => 'two factor authentication enabled'
        ]);
    }

    public function disable(SaveTwoFactorRequest $request)
    {
        $twoFaCode = $request->get('two_factor_code');

        //check if user have temp 2fa
        $user = Auth::user();

        if ($user === null) {
            throw new UnauthorizedHttpException('', $this->userNotLoggedMsg);
        }

        if ($user->secret_2fa === null) {
            throw new AccessDeniedHttpException($this->notEnableMsg);
        }

        if (!TwoFactorHelper::verifyCode($user, $twoFaCode)) {
            throw new HttpException(500);
        }

        TwoFactorHelper::disableSave($user);

        return ResponseHelper::success([
            'msg' => 'two factor authentication disabled'
        ]);
    }

    public function verify(SaveTwoFactorRequest $request)
    {
        $twoFaCode = $request->get('two_factor_code');

        //check if user have temp 2fa
        $user = Auth::user();

        if ($user === null) {
            throw new UnauthorizedHttpException('', $this->userNotLoggedMsg);
        }

        if ($user->secret_2fa === null) {
            throw new AccessDeniedHttpException($this->notEnableMsg);
        }

        if (!TwoFactorHelper::verifyCode($user, $twoFaCode)) {
            throw new HttpException(500);
        }

        return ResponseHelper::success([
            'msg' => 'two factor authentication verification passed'
        ]);
    }

    public function check()
    {
        $user = Auth::user();

        if ($user === null) {
            throw new UnauthorizedHttpException('', $this->userNotLoggedMsg);
        }

        if ($user->secret_2fa === null) {
            throw new NotFoundHttpException($this->notEnableMsg);
        }

        return ResponseHelper::success([
            'msg' => $this->enabledMsg
        ]);
    }
}