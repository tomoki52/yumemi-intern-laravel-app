<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithFaker;
    public function test_example()
    {
        $test_data = [
            'name' => 'k_nakano',
            'email' => 'k_nakano@example.com',
        ];
        $response = $this->postJson('/api/user', $test_data);
        $this->assertDatabaseHas('users', $test_data);
        $response->assertExactJson(
            [
                'message' => 'User record created',
            ]);
        $response->assertStatus(200);

    }
}
