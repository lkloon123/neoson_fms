<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Helper;


use App\Models\User;
use PragmaRX\Google2FA\Google2FA;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TwoFactorHelper
{
    public static function verifyCode($user, $twoFaCode)
    {
        User::disableAuditing();
        $secret = null;
        if ($user->temp_2fa === null && $user->secret_2fa === null) {
            throw new NotFoundHttpException('please setup two factor authentication first');
        }

        /** @var User $user */
        if ($user->temp_2fa === null) {
            $secret = $user->secret_2fa;
        } else {
            $secret = $user->temp_2fa;
        }

        $google2fa = new Google2FA();
        $timestamp = $google2fa->verifyKeyNewer($secret, $twoFaCode, $user->timestamp_2fa);

        if ($timestamp === false) {
            throw new AccessDeniedHttpException('incorrect two factor authentication code');
        }

        $user->timestamp_2fa = $timestamp;
        $user->save();

        return true;
    }

    public static function enableSave($user)
    {
        User::disableAuditing();
        /** @var User $user */
        $user->secret_2fa = $user->temp_2fa;
        $user->temp_2fa = null;
        $user->save();
    }

    public static function disableSave($user)
    {
        User::disableAuditing();
        /** @var User $user */
        $user->secret_2fa = null;
        $user->timestamp_2fa = null;
        $user->save();
    }
}