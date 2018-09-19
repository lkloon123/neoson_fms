<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Functional\Api\V1\Controllers;

use App\Models\Farm;
use App\Models\FarmUser;
use App\Models\Miner;
use Bouncer;

class MinerControllerTest extends BaseControllerTest
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

        Miner::create([
            'miner_name' => 'Test Miner',
            'cuda_ver' => 7,
            'farm_id' => $farm->id
        ]);
    }

    #region view
    public function testGetMinerWithoutLoginWithReturnsUnauthorisedError()
    {
        $this->get('api/miner')
            ->assertStatus(401);
    }

    public function testGetAllMinerSuccessfully()
    {
        $this->get('api/miner?token=' . parent::getToken())->assertJsonStructure([
            'success',
            'data',
            'links',
            'meta'
        ])->assertStatus(200);
    }

    public function testGetSingleMinerSuccessfully()
    {
        $this->get('api/miner/1?token=' . parent::getToken())->assertJsonStructure([
            'success',
            'data'
        ])->assertStatus(200);
    }

    public function testGetSingleMinerWithReturnsNotFoundError()
    {
        $this->get('api/miner/100?token=' . parent::getToken())->assertJsonStructure([
            'error'
        ])->assertStatus(404);
    }
    #endregion

    #region create
    public function testCreateMinerSuccessfully()
    {
        Bouncer::allow($this->user)->to('farm_1_update');
        $token = parent::getToken();
        $response = $this->post('api/miner?token=' . $token, [
            'miner_name' => 'testing miner',
            'cuda_ver' => 7,
            'farm_id' => 1
        ])->assertJsonStructure([
            'success',
            'data'
        ])->assertStatus(201);

        $responseJSON = json_decode($response->getContent(), true);

        $this->get('api/miner/' . $responseJSON['data']['id'] . '?token=' . $token)
            ->assertStatus(200);
    }

    public function testCreateMinerWithReturnsInvalidFormatError()
    {
        Bouncer::allow($this->user)->to('farm_1_update');
        $token = parent::getToken();
        $this->post('api/miner?token=' . $token, [
            'available' => 'asd',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);

        $this->get('api/miner/2?token=' . $token)
            ->assertStatus(404);
    }

    public function testCreateDuplicateMinerNameWithReturnsInvalidFormatError()
    {
        Bouncer::allow($this->user)->to('farm_1_update');
        $token = parent::getToken();
        $this->post('api/miner?token=' . $token, [
            'miner_name' => 'Test Miner',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);

        $this->get('api/miner/2?token=' . $token)
            ->assertStatus(404);
    }

    public function testCreateMinerWithReturnsForbiddenError()
    {
        $token = parent::getToken();
        $this->post('api/miner?token=' . $token, [
            'miner_name' => 'testing miner',
            'cuda_ver' => 7,
            'farm_id' => 1
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(403);

        $this->get('api/miner/2?token=' . $token)
            ->assertStatus(404);
    }
    #endregion

    #region update
    public function testUpdateMinerSuccessfully()
    {
        Bouncer::allow($this->user)->to('farm_1_update');
        $token = parent::getToken();
        $this->put('api/miner/1?token=' . $token . '&miner_name=testminer2')
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);

        $this->get('api/miner/1?token=' . $token)
            ->assertJsonFragment(['miner_name' => 'testminer2'])
            ->assertStatus(200);
    }

    public function testUpdateMinerWithReturnsForbiddenError()
    {
        $token = parent::getToken();
        $this->put('api/miner/1?token=' . $token . '&miner_name=testminer2')
            ->assertJsonStructure([
                'error'
            ])->assertStatus(403);

        $this->get('api/miner/1?token=' . $token)
            ->assertJsonFragment(['miner_name' => 'Test Miner'])
            ->assertStatus(200);
    }

    public function testUpdateMinerWithReturnsInvalidFormatError()
    {
        Bouncer::assign('farm_1_update')->to($this->user);
        $token = parent::getToken();
        $this->put('api/miner/1?token=' . $token, [
            'available' => 'asd',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);

        $this->get('api/miner/1?token=' . $token)
            ->assertJsonFragment(['miner_name' => 'Test Miner'])
            ->assertStatus(200);
    }
    #endregion

    #region delete
    public function testDeleteMinerSuccessfully()
    {
        Bouncer::allow($this->user)->to('farm_1_update');
        $token = parent::getToken();
        $this->delete('api/miner/1?token=' . $token)
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);

        $this->get('api/miner/1?token=' . $token)
            ->assertStatus(404);
    }

    public function testDeleteMinerWithReturnsForbiddenError()
    {
        $token = parent::getToken();
        $this->delete('api/miner/1?token=' . $token)
            ->assertJsonStructure([
                'error'
            ])->assertStatus(403);

        $this->get('api/miner/1?token=' . $token)
            ->assertStatus(200);
    }
    #endregion
}