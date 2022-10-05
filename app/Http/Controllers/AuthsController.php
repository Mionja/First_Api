<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash; 

class AuthsController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        //Check email
        $user = User::where('email',$fields['email'])->first();

        //Check password
        if (!$user) { 
            return [
                'message'=> 'Bad email'
            ];
        }
        elseif (!Hash::check($fields['password'], $user->password)) {
            return [
                'message'=> 'Bad password'
            ];
        }

        $token = $user->createToken('mytoken')->plainTextToken;

        $response = [
            'user'=> $user['name'],
            'token'=> $token,
        ];

        return response($response, 201); //201 is to confirm that everything was successfull and something is created
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }
}
