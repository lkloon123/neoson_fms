<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Functional\Api\V1\Controllers;

use App\Models\User;
use App\TestCase;
use Bouncer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Constraint\IsType;

class BaseControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Test',
            'email' => 'test@email.com',
            'password' => '123456',
            'available' => true,
        ]);
    }

    protected function getToken()
    {
        $response = $this->post('api/auth/login', [
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);

        $responseJSON = json_decode($response->getContent(), true);
        return $responseJSON['data']['token'];
    }

    protected function assignSU()
    {
        Bouncer::allow('superuser')->everything();
        Bouncer::assign('superuser')->to(User::find(1));
    }

    public function testUserCreationAndToken()
    {
        $this->assertInternalType(IsType::TYPE_STRING, $this->getToken());
    }
}