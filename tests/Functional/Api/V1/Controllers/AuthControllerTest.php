<?php

namespace App\Functional\Api\V1\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Config;
use DB;

class AuthControllerTest extends BaseControllerTest
{
    public function setUp()
    {
        parent::setUp();

        User::create([
            'name' => 'Test2',
            'email' => 'test2@email.com',
            'password' => '123456'
        ]);

        DB::table('password_resets')->insert([
            'email' => 'test@email.com',
            'token' => bcrypt('my_super_secret_code'),
            'created_at' => Carbon::now()
        ]);
    }

    #region Forget Password
    public function testForgotPasswordRecoverySuccessfully()
    {
        $this->post('api/auth/recovery', [
            'email' => 'test@email.com'
        ])->assertJson([
            'success' => true,
            'data' => [
                'msg' => 'password reset email has been sent'
            ]
        ])->assertStatus(200);
    }

    public function testForgotPasswordRecoveryReturnsUserNotFoundError()
    {
        $this->post('api/auth/recovery', [
            'email' => 'unknown@email.com'
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(404);
    }

    public function testForgotPasswordRecoveryReturnsValidationErrors()
    {
        $this->post('api/auth/recovery', [
            'email' => 'i am not an email'
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);
    }
    #endregion

    #region Login
    public function testLoginSuccessfully()
    {
        $this->post('api/auth/login', [
            'email' => 'test@email.com',
            'password' => '123456'
        ])->assertJson([
            'success' => true
        ])->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'duration',
                'expired_at',
                'timezone'
            ]
        ])->assertStatus(200);
    }

    public function testLoginWithReturnsUserNotActiveError()
    {
        $this->post('api/auth/login', [
            'email' => 'test2@email.com',
            'password' => '123456'
        ])->assertJson([
            'success' => false,
            'error' => [
                'message' => 'user not activated',
                'status_code' => 401
            ]
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(401);
    }

    public function testLoginWithReturnsWrongCredentialsError()
    {
        $this->post('api/auth/login', [
            'email' => 'unknown@email.com',
            'password' => '123456'
        ])->assertJson([
            'success' => false
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(401);
    }

    public function testLoginWithReturnsValidationError()
    {
        $this->post('api/auth/login', [
            'email' => 'test@email.com'
        ])->assertJson([
            'success' => false
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);
    }
    #endregion

    #region Logout
    public function testLogout()
    {
        $token = parent::getToken();
        $this->post('api/auth/logout?token=' . $token, [], [])->assertStatus(200);
        $this->post('api/auth/logout?token=' . $token, [], [])->assertStatus(401);
    }
    #endregion

    #region Refresh
    public function testRefresh()
    {
        $this->post('api/auth/refresh', [], [
            'Authorization' => 'Bearer ' . parent::getToken()
        ])->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'duration',
                'expired_at',
                'timezone'
            ]
        ])->assertStatus(200);
    }

    public function testRefreshWithError()
    {
        $response = $this->post('api/auth/refresh', [], [
            'Authorization' => 'Bearer Wrong'
        ]);

        $response->assertStatus(401);
    }
    #endregion

    #region Reset Password
    public function testResetSuccessfully()
    {
        $this->post('api/auth/reset', [
            'email' => 'test@email.com',
            'token' => 'my_super_secret_code',
            'password' => 'mynewpass',
            'password_confirmation' => 'mynewpass'
        ])->assertJson([
            'success' => true,
            'data' => [
                'msg' => 'successfully reset password'
            ]
        ])->assertStatus(200);
    }

    public function testResetSuccessfullyWithTokenRelease()
    {
        Config::set('jwt.release_token.reset_password', true);

        $this->post('api/auth/reset', [
            'email' => 'test@email.com',
            'token' => 'my_super_secret_code',
            'password' => 'mynewpass',
            'password_confirmation' => 'mynewpass'
        ])->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'msg'
            ]
        ])->assertJson([
            'success' => true
        ])->assertStatus(200);
    }

    public function testResetReturnsProcessError()
    {
        $this->post('api/auth/reset', [
            'email' => 'unknown@email.com',
            'token' => 'this_code_is_invalid',
            'password' => 'mynewpass',
            'password_confirmation' => 'mynewpass'
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(500);
    }

    public function testResetReturnsValidationError()
    {
        $this->post('api/auth/reset', [
            'email' => 'test@email.com',
            'token' => 'my_super_secret_code',
            'password' => 'mynewpass'
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);
    }
    #endregion

    #region Sign Up
    public function testSignUpSuccessfully()
    {
        $this->post('api/auth/signup', [
            'name' => 'Test User 3',
            'email' => 'test3@email.com',
            'password' => '123456'
        ])->assertJson([
            'success' => true,
            'data' => [
                'msg' => 'successfully created user',
            ]
        ])->assertStatus(201);
    }

    public function testSignUpSuccessfullyWithTokenRelease()
    {
        Config::set('jwt.release_token.sign_up', true);

        $this->post('api/auth/signup', [
            'name' => 'Test User 3',
            'email' => 'test3@email.com',
            'password' => '123456'
        ])->assertJsonStructure([
            'success',
            'data' => [
                'msg',
                'token'
            ]
        ])->assertJson([
            'success' => true
        ])->assertStatus(201);
    }

    public function testSignUpReturnsValidationError()
    {
        $this->post('api/auth/signup', [
            'name' => 'Test User',
            'email' => 'test@email.com'
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);
    }
    #endregion

    #region me
    public function testMe()
    {
        $this->get('api/auth/me?token=' . parent::getToken())->assertJsonStructure([
            'success',
            'data'
        ])->assertStatus(200);
    }
    #endregion
}
