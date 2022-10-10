<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name'     => 'required',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:8',
                'role_id'  => 'required',
            ]);

            if ($validation->fails()) {
                return response()->json(['message' => "{$validation->getMessageBag()->first()}"], 400);
            }

            $request['password'] = bcrypt($request->password);
            $user                = User::create($request->all());
            $token               = $user->createToken('API Token')->accessToken;
            return response(['user' => $user, 'token' => $token]);

        } catch (Throwable $th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }
}
