<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_create()
    {
        $test_data = [
            'name' => 'k_nakano',
            'email' => 'k_nakano@example.com',
            'password' => 'password',
        ];
        $expected = [
            'name' => 'k_nakano',
            'email' => 'k_nakano@example.com',
        ];
        $response = $this->postJson('/api/user', $test_data);
        $this->assertDatabaseHas('users', $expected);


        $response->assertStatus(ResponseCode::HTTP_OK);

    }

    public function test_user_login()
    {
        $test_data = [
            'name' => 'k_nakano',
            'email' => 'k_nakano@example.com',
            'password' => 'password',
        ];
        $test_login_data = [
            'email' => 'k_nakano@example.com',
            'password' => 'password',
        ];
        $this->postJson('/api/user', $test_data);
        $response = $this->postJson('/api/user/login', $test_login_data);
        $response->assertStatus(ResponseCode::HTTP_OK);


    }

}
