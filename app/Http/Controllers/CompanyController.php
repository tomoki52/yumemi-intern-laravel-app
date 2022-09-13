<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CompanyController extends Controller
{
    //
    public function createCompany(Request $request)
    {
        $company = Company::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'profile' => $request->input('profile'),
        ]);
        return response()->json(
            [

        ],
            ResponseCode::HTTP_OK
        );
    }
    public function loginCompany(Request $request)
    {
        $company = Company::where('email', $request->email)->first();
        if (empty($company)) {
            return response()->json(
                [

            ],
                ResponseCode::HTTP_UNAUTHORIZED
            );
        }

        if (Hash::check($request->password, $company->password)) {
            $token = $company->createToken($request->email);
            return response()->json(
                [

                'token' => $token->plainTextToken,
            ],
                ResponseCode::HTTP_OK
            );
        } else {
            return response()->json(
                [

            ],
                ResponseCode::HTTP_UNAUTHORIZED
            );
        }
    }
    public function getInterview(Request $request)
    {
        $company = $request->user();
        if ($request->has('interview_id')) {
            $interview = Interview::where('id', $request->interview_id)->first();
            $user_id = $interview->user_id;
            $user_name = User::where('id', $user_id)->first()->name;
            return response()->json([

                'user_name'=>$user_name,
                'interview_datetime' => $interview->datetime,
                'interview_status' => $interview->status,
            ],ResponseCode::HTTP_OK);
        } else {

            $interview_all = Interview::where('company_id', $company->id)->get();
            $response = [];
            foreach ($interview_all as $interview) {
                $user_id = $interview->user_id;
                $user_name = User::where('id', $user_id)->first()->name;
                $datetime = $interview->interview_datetime;
                $status = $interview->interview_status;

                $response[] = [
                    'user_name' => $user_name,
                    'interview_datetime' => $datetime,
                    'interview_status' => $status,
                ];
            }


            return response()->json($response, ResponseCode::HTTP_OK);
        }

    }
}
