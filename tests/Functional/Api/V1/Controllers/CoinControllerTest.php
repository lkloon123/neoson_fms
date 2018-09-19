<?php

namespace App\Functional\Api\V1\Controllers;

use App\Models\Coin;

class CoinControllerTest extends BaseControllerTest
{
    public function setUp()
    {
        parent::setUp();

        Coin::create([
            'coin_name' => 'Test Coin',
            'coin_ticker' => 'TST',
            'explorer_link' => 'http://test.test.com',
            'available' => true,
        ]);
    }

    #region view
    public function testGetAllCoinSuccessfully()
    {
        $this->get('api/public/coin')
            ->assertJsonStructure([
                'success',
                'data',
                'links',
                'meta'
            ])->assertStatus(200);
    }

    public function testGetSingleCoinSuccessfully()
    {
        $this->get('api/public/coin/1')
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);
    }

    public function testGetSingleCoinWithReturnsNotFoundError()
    {
        $this->get('api/public/coin/100')
            ->assertJsonStructure([
                'error'
            ])->assertStatus(404);
    }
    #endregion

    #region create
    public function testCreateCoinSuccessfully()
    {
        parent::assignSU();

        $response = $this->post('api/coin?token=' . parent::getToken(), [
            'coin_name' => 'test coin',
            'coin_ticker' => 'test ticker',
            'coin_algo' => 'test algo',
        ])->assertJsonStructure([
            'success',
            'data'
        ])->assertStatus(201);

        $responseJSON = json_decode($response->getContent(), true);

        $this->get('api/public/coin/' . $responseJSON['data']['id'])
            ->assertStatus(200);
    }

    public function testCreateCoinWithReturnsForbiddenError()
    {
        $this->post('api/coin?token=' . parent::getToken(), [
            'coin_name' => 'test coin',
            'coin_ticker' => 'test ticker',
            'coin_algo' => 'test algo',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(403);

        $this->get('api/public/coin/2')
            ->assertStatus(404);
    }

    public function testCreateCoinWithReturnsInvalidFormatError()
    {
        parent::assignSU();

        $this->post('api/coin?token=' . parent::getToken(), [
            'coin_name' => 'test wrong coin',
            'coin_ticker' => 'test ticker',
        ])->assertJsonStructure([
            'error'
        ])->assertStatus(422);

        $this->get('api/public/coin/2')
            ->assertStatus(404);
    }
    #endregion

    #region update
    public function testUpdateCoinSuccessfully()
    {
        parent::assignSU();

        $this->put('api/coin/1?token=' . parent::getToken() . '&coin_name=testcoin2')
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);

        $this->get('api/public/coin/1')
            ->assertJsonFragment(['coin_name' => 'testcoin2'])
            ->assertStatus(200);
    }

    public function testUpdateCoinWithReturnsForbiddenError()
    {
        $this->put('api/coin/1?token=' . parent::getToken() . '&coin_name=testcoin2')
            ->assertJsonStructure([
                'error'
            ])->assertStatus(403);

        $this->get('api/public/coin/1')
            ->assertJsonFragment(['coin_name' => 'Test Coin'])
            ->assertStatus(200);
    }

    public function testUpdateCoinWithReturnsInvalidFormatError()
    {
        parent::assignSU();

        $this->put('api/coin/1?token=' . parent::getToken() . '&explorer_link=testError')
            ->assertJsonStructure([
                'error'
            ])->assertStatus(422);

        $this->get('api/public/coin/1')
            ->assertJsonFragment(['explorer_link' => 'http://test.test.com'])
            ->assertStatus(200);
    }
    #endregion

    #region delete
    public function testDeleteCoinSuccessfully()
    {
        parent::assignSU();

        $this->delete('api/coin/1?token=' . parent::getToken())
            ->assertJsonStructure([
                'success',
                'data'
            ])->assertStatus(200);

        $this->get('api/public/coin/1')
            ->assertStatus(404);
    }

    public function testDeleteCoinWithReturnsForbiddenError()
    {
        $this->delete('api/coin/1?token=' . parent::getToken())
            ->assertJsonStructure([
                'error'
            ])->assertStatus(403);

        $this->get('api/public/coin/1')
            ->assertStatus(200);
    }
    #endregion
}
