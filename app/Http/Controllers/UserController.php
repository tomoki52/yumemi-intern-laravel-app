<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function createUser(Request $request){

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return response()->json([
                'message' => 'User record created',
            ],
            200);
    }
    public function  loginUser(Request $request){
        $user = User::where('email',$request->email)->first();
        if(empty($user)) {
            return response()->json([
                'message' => 'user is not found.'
            ],
                404);
        }

        if(Hash::check($request->password,$user->password)){
            $token = $user->createToken($request->email);
            return response()->json([
                'message'=> 'login is successful.',
                'token' => $token->plainTextToken,
            ],
            200);
        }else{
            return response()->json([
                'message'=>'password is wrong.'
            ],
            400);
        }

    }
}
