<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $response->assertExactJson(
            [
                'message' => 'User record created',
            ]);

        $response->assertStatus(200);

    }
}
