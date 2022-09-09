<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
class UserController extends Controller
{
    //
    public function createUser(Request $request){

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'profile' => $request->input('profile'),
        ]);
        return response()->json([

            ],
            ResponseCode::HTTP_OK);
    }
    public function  loginUser(Request $request){
        $user = User::where('email',$request->email)->first();
        if(empty($user)) {
            return response()->json([

            ],
                ResponseCode::HTTP_UNAUTHORIZED);
        }

        if(Hash::check($request->password,$user->password)){
            $token = $user->createToken($request->email);
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
}
