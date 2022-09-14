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
    use WithFaker;
    public function test_company_create()
    {
        Spectator::using('openapi.yaml');
        $test_data = [
            'name' => $this->faker->name,
            'email' => 'ex_company@example.com',
            'password' => $this->faker->password,
            'profile' => $this->faker->text,
        ];
        $expected = [
            'name' => $test_data['name'],
            'email' => $test_data['email'],
            'profile' => $test_data['profile'],
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
        Spectator::using('openapi.yaml');
        $company = Company::factory()->create(
            ['email' => 'ex_company2@example.com'],
        );
        $test_login_data=[
            'email'=>$company->email,
            'password'=>'password',
        ];

        $response = $this->postJson('/api/company/login', $test_login_data);
        $response
            ->assertValidRequest()
            ->assertValidResponse(ResponseCode::HTTP_OK);
    }

    public function test_company_getInterview()
    {
        $company = Company::factory()->create(
            ['email' => 'ex_company@example.com'],
        );
        $test_login_data=[
            'email'=>$company->email,
            'password'=>'password',
        ];

        $token = $this->postJson('/api/company/login', $test_login_data)['token'];

        $user = User::factory()->create(
            ['email'=> 'user@example.com'],
        );
        $expected_detail = [
            'interview_datetime'=>null,
            'interview_status'=>3,
            'user_name'=>$user->name,
        ];
        $expected = [
            $expected_detail
        ];

        Interview::create([
            'user_id'=>$user->id,
            'company_id'=>$company->id,
        ]);

        $response = $this->getJson(
            '/api/company/interview',
            [
               'Authorization' => 'Bearer '.$token,
                ]
        );
        $response
            ->assertValidRequest()
            ->assertExactJson($expected)
            ->assertValidResponse(ResponseCode::HTTP_OK);

        $interview = Interview::where('user_id', $user->id)
            ->where('company_id', $company->id)->first();
        $interview_id = $interview->id;
        $response = $this->getJson(
            '/api/company/interview/'.$interview_id,
            [
                'Authorization' => 'Bearer '.$token,
            ]
        );

        $response
            ->assertValidRequest()
            ->assertExactJson($expected_detail)
            ->assertValidResponse(ResponseCode::HTTP_OK);

        $response=$this->postJson(
            'api/company/interview/'.$interview_id.'/decision',
            [
                'status'=>1
            ]
        );
        $response
            ->assertValidRequest()
            ->assertValidResponse(ResponseCode::HTTP_OK);
    }
}
