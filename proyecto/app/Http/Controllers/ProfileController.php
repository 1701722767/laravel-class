<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

            $validation = Validator::make($request->all(), [
                'user_id'      => 'required|exists:users,id',
                'iamge'        => 'file|max:25600|mimes:png,jpg',
                'phone_number' => 'required',
                'url_facebook' => 'required',
            ]);

            if ($validation->fails()) {
                return response()->json(['message' => $validation->getMessageBag()->first()], 400);
            }

            $file = $request->file('image');

            if ($file) {
                $md5Name        = md5_file($file->getRealPath());
                $guessExtension = $file->guessExtension();
                $nameDocument   = time() . $md5Name . '.' . $guessExtension;
                $file->storeAs('profile_images', $nameDocument);
            }

            $profile = new Profile();

            $data          = $request->all();
            $data['image'] = $nameDocument;
            $profile->fill($data);
            $profile->save();

            $profile->image = $nameDocument;

            return response()->json($profile, 201);
        } catch (\Throwable$th) {
            Log::critical("store_profile_failed", ["error" => $th, "error_tracer" => $th->getTraceAsString()]);

            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function update(Profile $profile, Request $request)
    {
        try {
            $profile->update($request->all());

            return response()->json($profile, 200);
        } catch (\Throwable$th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function destroy(Profile $profile)
    {
        try {
            $profile->delete();

            return response()->json(null, 204);
        } catch (\Throwable$th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }
}
