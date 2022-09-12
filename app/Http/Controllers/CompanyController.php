<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CompanyController extends Controller
{
    //
    public function createCompany(Request $request){

        $company = Company::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'profile' => $request->input('profile'),
        ]);
        return response()->json([

        ],
            ResponseCode::HTTP_OK);
    }
    public function  loginCompany(Request $request){
        $company = Company::where('email',$request->email)->first();
        if(empty($company)) {
            return response()->json([

            ],
                ResponseCode::HTTP_UNAUTHORIZED);
        }

        if(Hash::check($request->password,$company->password)){
            $token = $company->createToken($request->email);
            return response()->json([

                'token' => $token->plainTextToken,
            ],
                ResponseCode::HTTP_OK);
        }else{
            return response()->json([

            ],
                ResponseCode::HTTP_UNAUTHORIZED);
        }

    }
    public function getInterview(Request $request){

        $interview = Interview::where('company_id',$request->company_id)->first();
        return response()->json(
            $interview,ResponseCode::HTTP_OK);
    }
}
