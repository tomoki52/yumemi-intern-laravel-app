<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        Spectator::using('openapi.yaml');

    }
    public function test_user_create()
    {
        $test_data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'profile' => $this->faker->text,
        ];

        $expected = [
            'name' => $test_data['name'],
            'email' => $test_data['email'],
            'profile' => $test_data['profile'],
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
        $user = User::factory()->create();
        $test_login_data=[
            'email'=>$user->email,
            'password'=>'password',
        ];
        $response = $this->postJson('/api/user/login', $test_login_data);
        $response
            ->assertValidRequest()
            ->assertValidResponse(ResponseCode::HTTP_OK);
    }
}
