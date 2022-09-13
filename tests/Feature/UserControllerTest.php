<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Tests\TestCase;
use Spectator\Spectator;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Spectator::using('openapi.yaml');
    }
    public function test_user_create()
    {
        $test_data = [
            'name' => 'k_nakano',
            'email' => 'k_nakano@example.com',
            'password' => 'password',
            'profile' => 'sample profile',
        ];
        $expected = [

            'name' => 'k_nakano',
            'email' => 'k_nakano@example.com',
            'profile' => 'sample profile',
        ];

        $response = $this->postJson('/api/user', $test_data);
        $this->assertDatabaseHas('users', $expected);

        $response
            ->assertValidRequest()
            ->assertExactJson([])
            ->assertValidResponse(ResponseCode::HTTP_OK);
    }

    public function test_user_login()
    {
        $test_create_data = [
            'name' => 't_konishi',
            'email' => 't_konishi@example.com',
            'password' => 'password',
            'profile' => 'sample profile',
        ];

        $test_login_data = [
            'email' => 't_konishi@example.com',
            'password' => 'password',
        ];

        $this->postJson('/api/user', $test_create_data);

        $response = $this->postJson('/api/user/login', $test_login_data);
        $response
            ->assertValidRequest()
            ->assertValidResponse(ResponseCode::HTTP_OK);
    }
}
