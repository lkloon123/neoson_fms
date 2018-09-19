<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Functional\Api\V1\Controllers;

use App\Models\Farm;
use App\Models\FarmUser;

class FarmControllerTest extends BaseControllerTest
{
    public function setUp()
    {
        parent::setUp();

        $farm = Farm::create([
            'farm_name' => 'Test Farm',
            'available' => true,
        ]);

        FarmUser::create([
            'farm_id' => $this->user->id,
            'user_id' => $farm->id,
        ]);
    }

    #region view
    public function testGetFarmWithoutLoginWithReturnsUnauthorisedError()
    {
        $this->get('api/farm')
            ->assertStatus(401);
    }

    public function testGetAllFarmSuccessfully()
    {
        $this->get('api/farm?token=' . parent::getToken())->assertJsonStructure([
            'success',
            'data',
            'links',
            'meta'
        ])->assertStatus(200);
    }

    public function testGetSingleFarmSuccessfully()
    {
        $this->get('api/farm/1?token=' . parent::getToken())->assertJsonStructure([
            'success',
            'data'
        ])->assertStatus(200);
    }

    public function testGetSingleFarmWithReturnsNotFoundError()
    {
        $this->get('api/farm/100?token=' . parent::getToken())->assertJsonStructure([
            'error'
        ])->assertStatus(404);
    }
    #endregion

    #region create
    public function testCreateFarmSuccessfully()
    {
        $token = parent::getToken();
        $response = $this->post('api/farm?token=' . $token, [
            'farm_name' => 'testing farm',
        ])->assertJsonStructure([
            'success',
            'data'
        ])->assertStatus(201);

        $responseJSON = json_decode($response->getContent(), true);

        $this->get('api/farm/' . $responseJSON['data']['id'] . '?token=' . $token)
            ->assertStatus(200);
    }

    public function testCreateFarmWithReturnsInvalidFormatError()
    {
        $token = parent::getToken();
        $this->post('api/farm?token=' . $token, [
            'available' => 'asd',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);

        $this->get('api/farm/2?token=' . $token)
            ->assertStatus(404);
    }

    public function testCreateDuplicateFarmNameWithReturnsInvalidFormatError()
    {
        $token = parent::getToken();
        $this->post('api/farm?token=' . $token, [
            'farm_name' => 'Test Farm',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);

        $this->get('api/farm/2?token=' . $token)
            ->assertStatus(404);
    }
    #endregion

    #region update
    public function testUpdateFarmSuccessfully()
    {
        parent::assignSU();
        $token = parent::getToken();
        $this->put('api/farm/1?token=' . $token . '&farm_name=testfarm2')
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);

        $this->get('api/farm/1?token=' . $token)
            ->assertJsonFragment(['farm_name' => 'testfarm2'])
            ->assertStatus(200);
    }

    public function testUpdateFarmWithReturnsForbiddenError()
    {
        $token = parent::getToken();
        $this->put('api/farm/1?token=' . $token . '&farm_name=testfarm2')
            ->assertJsonStructure([
                'error'
            ])->assertStatus(403);

        $this->get('api/farm/1?token=' . $token)
            ->assertJsonFragment(['farm_name' => 'Test Farm'])
            ->assertStatus(200);
    }

    public function testUpdateFarmWithReturnsInvalidFormatError()
    {
        parent::assignSU();
        $token = parent::getToken();
        $this->put('api/farm/1?token=' . $token, [
            'available' => 'asd',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);

        $this->get('api/farm/1?token=' . $token)
            ->assertJsonFragment(['farm_name' => 'Test Farm'])
            ->assertStatus(200);
    }
    #endregion

    #region delete
    public function testDeleteFarmSuccessfully()
    {
        parent::assignSU();
        $token = parent::getToken();
        $this->delete('api/farm/1?token=' . $token)
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);

        $this->get('api/farm/1?token=' . $token)
            ->assertStatus(404);
    }

    public function testDeleteFarmWithReturnsForbiddenError()
    {
        $token = parent::getToken();
        $this->delete('api/farm/1?token=' . $token)
            ->assertJsonStructure([
                'error'
            ])->assertStatus(403);

        $this->get('api/farm/1?token=' . $token)
            ->assertStatus(200);
    }
    #endregion
}