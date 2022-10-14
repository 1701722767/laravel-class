<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UsersController extends Controller
{

    public function index()
    {
        try {
            return User::with('role', "profile")->get();
        } catch (\Throwable $th) {
            Log::critical("list_users_failed", ["error" => $th, "error_tracer" => $th->getTraceAsString()]);

            return response(['message' => 'internal server error'], 500);
        }
    }

    public function show(User $user)
    {
        try {
            return $user->with('role', "profile")->first();
        } catch (\Throwable $th) {
            Log::critical("show_user_failed", ["error" => $th, "error_tracer" => $th->getTraceAsString()]);

            return response(['message' => 'internal server error'], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            return $user->delete();
        } catch (\Throwable $th) {
            Log::critical("delete_user_failed", ["error" => $th, "error_tracer" => $th->getTraceAsString()]);

            return response(['message' => 'internal server error'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name'     => 'required',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:8',
                'role_id'  => 'required|exists:roles,id',
            ]);

            if ($validation->fails()) {
                return response()->json(['message' => "{$validation->getMessageBag()->first()}"], 400);
            }

            $request['password'] = bcrypt($request->password);
            $user                = User::create($request->all());
            $token               = $user->createToken('API Token')->accessToken;
            return response(['user' => $user, 'token' => $token]);

        } catch (Throwable $th) {
            Log::critical("store_user_failed", ["error" => $th, "error_tracer" => $th->getTraceAsString()]);

            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function update(User $user, Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name'     => 'min:4',
                'email'    => 'email|unique:users,email,' . $user->id,
                'password' => 'min:8',
                'role_id'  => 'exists:roles,id',
            ]);

            if ($validation->fails()) {
                return response()->json(['message' => "{$validation->getMessageBag()->first()}"], 400);
            }

            $request['password'] = bcrypt($request->password);
            $user                = $user->fill($request->all());
            $user->update();

            return response(['user' => $user]);

        } catch (Throwable $th) {
            Log::critical("store_user_failed", ["error" => $th, "error_tracer" => $th->getTraceAsString()]);

            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

}
