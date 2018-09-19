<?php

namespace App\Functional\Api\V1\Controllers;

use App\Models\Pool;

class PoolControllerTest extends BaseControllerTest
{
    public function setUp()
    {
        parent::setUp();

        Pool::create([
            'pool_name' => 'Test Pool',
            'pool_stratum' => 'test stratum',
            'pool_url' => 'http://test.test.com',
            'available' => true,
        ]);
    }

    #region view
    public function testGetAllPoolSuccessfully()
    {
        $this->get('api/public/pool')
            ->assertJsonStructure([
                'success',
                'data',
                'links',
                'meta'
            ])->assertStatus(200);
    }

    public function testGetSinglePoolSuccessfully()
    {
        $this->get('api/public/pool/1')
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);
    }

    public function testGetSinglePoolWithReturnsNotFoundError()
    {
        $this->get('api/public/pool/100')
            ->assertJsonStructure([
                'error'
            ])->assertStatus(404);
    }
    #endregion

    #region create
    public function testCreatePoolSuccessfully()
    {
        parent::assignSU();

        $response = $this->post('api/pool?token=' . parent::getToken(), [
            'pool_name' => 'test pool',
            'pool_stratum' => 'test stratum',
            'pool_url' => 'http://test.test.com',
        ])->assertJsonStructure([
            'success',
            'data'
        ])->assertStatus(201);

        $responseJSON = json_decode($response->getContent(), true);

        $this->get('api/public/pool/' . $responseJSON['data']['id'])
            ->assertStatus(200);
    }

    public function testCreatePoolWithReturnsForbiddenError()
    {
        $this->post('api/pool?token=' . parent::getToken(), [
            'pool_name' => 'test pool',
            'pool_stratum' => 'test stratum',
            'pool_url' => 'http://test.test.com',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(403);

        $this->get('api/public/pool/2')
            ->assertStatus(404);
    }

    public function testCreatePoolWithReturnsInvalidFormatError()
    {
        parent::assignSU();

        $this->post('api/pool?token=' . parent::getToken(), [
            'pool_name' => 'test wrong pool',
            'pool_url' => 'http://test.test.com',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);

        $this->get('api/public/pool/2')
            ->assertStatus(404);
    }
    #endregion

    #region update
    public function testUpdatePoolSuccessfully()
    {
        parent::assignSU();

        $this->put('api/pool/1?token=' . parent::getToken() . '&pool_name=testpool2')
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);

        $this->get('api/public/pool/1')
            ->assertJsonFragment(['pool_name' => 'testpool2'])
            ->assertStatus(200);
    }

    public function testUpdatePoolWithReturnsForbiddenError()
    {
        $this->put('api/pool/1?token=' . parent::getToken() . '&pool_name=testpool2')
            ->assertJsonStructure([
                'error'
            ])->assertStatus(403);

        $this->get('api/public/pool/1')
            ->assertJsonFragment(['pool_name' => 'Test Pool'])
            ->assertStatus(200);
    }

    public function testUpdatePoolWithReturnsInvalidFormatError()
    {
        parent::assignSU();

        $this->put('api/pool/1?token=' . parent::getToken() . '&pool_url=testpool2')
            ->assertJsonStructure([
                'error'
            ])->assertStatus(422);

        $this->get('api/public/pool/1')
            ->assertJsonFragment(['pool_url' => 'http://test.test.com'])
            ->assertStatus(200);
    }
    #endregion

    #region delete
    public function testDeletePoolSuccessfully()
    {
        parent::assignSU();

        $this->delete('api/pool/1?token=' . parent::getToken())
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);

        $this->get('api/public/pool/1')
            ->assertStatus(404);
    }

    public function testDeletePoolWithReturnsForbiddenError()
    {
        $this->delete('api/pool/1?token=' . parent::getToken())
            ->assertJsonStructure([
                'error'
            ])->assertStatus(403);

        $this->get('api/public/pool/1')
            ->assertStatus(200);
    }
    #endregion
}
