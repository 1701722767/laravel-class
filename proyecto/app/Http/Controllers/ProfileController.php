<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json(Profile::all(), 200);
    }

    public function show(Profile $profile)
    {
        if (!$profile) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($profile, 200);
    }

    public function store(Request $request)
    {
        try {
            $profile = new Profile();
            $profile->fill($request->all());
            $profile->save();

            return response()->json($profile, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function update(Profile $profile, Request $request)
    {
        try {
            $profile->update($request->all());

            return response()->json($profile, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function destroy(Profile $profile)
    {
        try {
            $profile->delete();

            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }
}
