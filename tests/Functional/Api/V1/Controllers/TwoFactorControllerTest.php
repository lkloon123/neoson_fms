<?php

namespace App\Functional\Api\V1\Controllers;

use App\Models\User;

class TwoFactorControllerTest extends BaseControllerTest
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testSetupTwoFactorSuccessfully()
    {
        $this->post('api/twofa/setup?token=' . parent::getToken())->assertJsonStructure([
            'success',
            'data'
        ])->assertStatus(200);
    }

    public function testVerifyTwoFactorWithReturnsUnauthorizedError()
    {
        $user = User::find(1);
        $user->update([
            'temp_2fa' => 'ADUMJO5634NPDEKW'
        ]);

        $this->post('api/twofa/setup/save?token=' . parent::getToken(), [
            'two_factor_code' => '123456'
        ])->assertStatus(403);
    }
}
