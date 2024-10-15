<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthApiController extends BaseApiController
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::whereEmail($request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($user->name.'-client-login')->plainTextToken;
            return $this->sendResponse([
              'access_token' => $token,
            ], "Welcome, $user->name");
        }
        return $this->sendError('Unmatched Credentials', [], 401);
    }

    public function register(Request $request){

    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return $this->sendResponse([],'You are logged out');
    }
}
