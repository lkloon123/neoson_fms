<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\ChangePasswordRequest;
use App\Api\V1\Requests\ForgotPasswordRequest;
use App\Api\V1\Requests\LoginRequest;
use App\Api\V1\Requests\RegisterRequest;
use App\Api\V1\Requests\ResetPasswordRequest;
use App\Api\V1\Requests\VerifyEmailRequest;
use App\Api\V1\Resources\UserResource;
use App\Helper\ResponseHelper;
use App\Mail\RegistrationToken;
use App\Mail\ResetPassword;
use App\Models\ApiToken;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Config;
use Hash;
use Mail;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends BaseController
{

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if ($this->isGoogleRecaptchaRequired($request->get('email'))) {
            if (!$request->exists('google_captcha_response') ||
                $request->get('google_captcha_response') === '' ||
                $request->get('google_captcha_response') === null) {
                return response()->json($this->generateInvalidGoogleRecaptchaMsg(), 422, [
                    'recaptcha' => 'required'
                ]);
            }
        }

        $token = Auth::guard()->attempt($credentials);

        if (!$token) {
            $user = User::whereEmail($request->get('email'))->first();
            if ($user !== null) {
                if ($user->login_attempt >= 2) {
                    throw new UnauthorizedHttpException('', 'incorrect email or password', null, 0, [
                        'recaptcha' => 'required'
                    ]);
                }
                $user->update([
                    'login_attempt' => $user->login_attempt + 1
                ]);
            }
            throw new UnauthorizedHttpException('', 'incorrect email or password');
        }

        if (!Auth::user()->available) {
            throw new UnauthorizedHttpException('', 'user not activated, please check your email for activation link');
        }

        Auth::user()->update([
            'login_attempt' => 0
        ]);

        return ResponseHelper::success([
            'token' => $token,
            'duration' => Auth::guard()->factory()->getTTL() * 60,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $requestData = $request->only(['name', 'email', 'password']);
        $user = User::create($requestData);
        $this->validateModel($user);

        $token = ApiToken::generate(ApiToken::$confirmEmail, $user);

        //send email
        Mail::to($user)
            ->send(new RegistrationToken($user, $token));

        return response()->json([
            'success' => true,
            'data' => [
                'msg' => 'registration success, please verify your email before login',
            ]
        ], 201);
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        $user = User::whereEmail($request->get('email'))->first();
        $this->validateUser($user);

        if ($user->available === true) {
            throw new AccessDeniedHttpException('user already activated');
        }

        /** @var ApiToken $apiToken */
        $apiToken = $user->apiTokens
            ->where('type', '=', 'confirm_email')
            ->sortByDesc('updated_at')
            ->first();

        if ($apiToken === null) {
            throw new AccessDeniedHttpException('no verification process for user');
        }

        if (!$apiToken->validateAndUse($request->get('confirm_token'))) {
            throw new UnauthorizedHttpException('', 'unauthorized token');
        }

        $user->update([
            'available' => true
        ]);
        $this->validateModel($user);

        return ResponseHelper::success([
            'msg' => 'email has been successfully verified'
        ]);
    }

    public function recoveryPassword(ForgotPasswordRequest $request)
    {
        $user = User::whereEmail($request->get('email'))->first();
        $this->validateUser($user);

        if (!$user->available) {
            throw new UnauthorizedHttpException('', 'user not activated');
        }

        $token = ApiToken::generate(ApiToken::$resetPassword, $user);

        //send email
        Mail::to($user)
            ->send(new ResetPassword($user, $token));

        return ResponseHelper::success([
            'msg' => 'password reset email has been sent'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request, JWTAuth $JWTAuth)
    {
        $user = User::whereEmail($request->get('email'))->first();
        $this->validateUser($user);

        /** @var ApiToken $apiToken */
        $apiToken = $user->apiTokens
            ->where('type', '=', 'reset_password')
            ->sortByDesc('updated_at')
            ->first();

        if ($apiToken === null) {
            throw new AccessDeniedHttpException('no reset password request for user');
        }

        if (!$apiToken->validateAndUse($request->get('reset_password_token'))) {
            throw new UnauthorizedHttpException('', 'unauthorized token');
        }

        $user->update([
            'password' => $request->get('password')
        ]);
        $this->validateModel($user);

        return ResponseHelper::success([
            'msg' => 'password successfully reset, please login using your new password',
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        /** @var User $user */
        $user = Auth::guard()->user();

        //check for existing password
        if (!Hash::check($request->get('old_password'), $user->password)) {
            throw new UnauthorizedHttpException('', 'incorrect password');
        }

        try {
            (new TwoFactorController())->check();

            //twofa set
            //check for two factor code
            if (!$request->get('two_factor_code')) {
                throw new HttpException(500, 'two factor code required');
            }

        } catch (NotFoundHttpException $e) {
            //twofa not set
        }

        $user->update([
            'password' => $request->get('new_password')
        ]);
        $this->validateModel($user);

        $this->logout();

        return ResponseHelper::success([
            'msg' => 'password successfully updated, you will be redirect to login page'
        ]);
    }

    public function logout()
    {
        Auth::guard()->logout();

        return ResponseHelper::success([
            'msg' => 'successfully logged out'
        ]);
    }

    public function refresh()
    {
        $token = Auth::guard()->refresh();
        \JWTAuth::setToken($token);
        $expDate = Carbon::createFromTimestamp(\JWTAuth::getPayload()['exp']);

        return ResponseHelper::success([
            'token' => $token,
            'duration' => Auth::guard()->factory()->getTTL() * 60,
            'expired_at' => $expDate->format(Config::get('app.datetime_format')),
            'timezone' => $expDate->timezoneName,
        ]);
    }

    public function me()
    {
        return ResponseHelper::success(new UserResource(Auth::user()));
    }

    private function isGoogleRecaptchaRequired($email)
    {
        $user = User::whereEmail($email)->first();
        if ($user !== null) {
            return $user->login_attempt >= 3;
        }
        return false;
    }

    private function generateInvalidGoogleRecaptchaMsg()
    {
        return [
            'success' => false,
            'error' => [
                'message' => '422 Unprocessable Entity',
                'errors' => [
                    'google_captcha_response' => [
                        'invalid captcha, please try again.'
                    ]
                ],
                'status_code' => 422,
            ]
        ];
    }
}