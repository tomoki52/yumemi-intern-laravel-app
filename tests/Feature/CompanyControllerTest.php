<?php

namespace Tests\Feature;

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Interview;
use App\Models\User;
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
    public function setUp(): void
    {
        parent::setUp();
        Spectator::using('openapi.yaml');
        $this->withoutExceptionHandling();
    }
    public function test_company_create()
    {
        $test_data = ['name' => 'ex_company', 'email' => 'ex_company@example.com', 'password' => 'password',
            'profile' => 'sample profile',
        ];
        $expected = ['name' => 'ex_company', 'email' => 'ex_company@example.com', 'profile' => 'sample profile',
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
            'name' => 'ex_company_login',
            'email' => 'ex_company_login@example.com',
            'password' => 'password',
            'profile' => 'sample profile',
        ];

        $test_login_data = [
            'email' => 'ex_company_login@example.com',
            'password' => 'password',
        ];

        $this->postJson('/api/company', $test_create_data);

        $response = $this->postJson('/api/company/login', $test_login_data);
        $response
            ->assertValidRequest()
            ->assertValidResponse(ResponseCode::HTTP_OK);
    }

    public function test_company_getInterview()
    {
        $test_company_data = [
            'name' => 'yumemi',
            'email' => 'yumemi@example.com',
            'password' => 'password',
            'profile' => 'sample profile',
        ];

        $test_login_data = [
            'email' => 'yumemi@example.com',
            'password' => 'password',
        ];
        $expected = [

            [

                'interview_datetime'=>null,
                'interview_status'=>'未確定',
                'user_name'=>'t_konishi',
            ],
        ];
        $this->postJson('/api/company', $test_company_data);
        $token = $this->postJson('/api/company/login', $test_login_data)['token'];
        print($token);

        $test_user_data = [
            'name' => 't_konishi',
            'email' => 't_konishi@example.com',
            'password' => 'password',
            'profile' => 'sample profile',
        ];
        $this->postJson('/api/user', $test_user_data);
        $user_id = User::where('email', $test_user_data['email'])->first()->id;
        $company_id = Company::where('email', $test_company_data['email'])->first()->id;
        Interview::create([
            'user_id'=>$user_id,
            'company_id'=>$company_id,
        ]);
        $response = $this->getJson(
            '/api/company/interview',
            [
               'Authorization' => 'Bearer '.$token,
                ]
        );
        $response
            ->assertExactJson($expected)
            ->assertStatus(ResponseCode::HTTP_OK);
    }
}
