<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email'    => 'email|required',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => "{$validation->getMessageBag()->first()}"], 400);
        }

        if (!auth()->attempt($request->all())) {
            return response(['message' => 'incorrect credentials'], 401);
        }

        Passport::personalAccessTokensExpireIn(now()->addMinutes(60));

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token, 'message' => 'login successful']);
    }

    public function logout(Request $request)
    {
        try {
            if (auth('api')->user()) {
                $user = auth('api')->user();
                $user->token()->revoke();
                return response(['message' => 'logout successful'], 200);
            }
            return response(['message' => 'logout failed'], 500);
        } catch (\Throwable $th) {
            return response(['message' => 'internal server error'], 500);
        }

    }

}
