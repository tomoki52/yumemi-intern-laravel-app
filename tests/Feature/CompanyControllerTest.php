<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spectator\Spectator;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function setUp() :void
    {
        parent::setUp();
        Spectator::using('openapi.yaml');
    }
    public function test_company_create()
    {
        $test_data = [
            'name' => 'yumemi',
            'email' => 'yumemi@example.com',
            'password' => 'password',
            'profile' => 'sample profile',
        ];
        $expected = [

            'name' => 'yumemi',
            'email' => 'yumemi@example.com',
            'profile' => 'sample profile',
        ];

        $response = $this->postJson('/api/company', $test_data);
        $this->assertDatabaseHas('companies', $expected);

        $response
            ->assertValidRequest()
            ->assertExactJson([])
            ->assertValidResponse(ResponseCode::HTTP_OK);
    }

    public function test_company_login()
    {
        $test_create_data = [
            'name' => 'yumemi',
            'email' => 'yumemi@example.com',
            'password' => 'password',
            'profile' => 'sample profile',
        ];

        $test_login_data = [
            'email' => 'yumemi@example.com',
            'password' => 'password',
        ];

        $this->postJson('/api/company', $test_create_data);

        $response = $this->postJson('/api/company/login', $test_login_data);
        $response
            ->assertValidRequest()
            ->assertValidResponse(ResponseCode::HTTP_OK);
    }
}
