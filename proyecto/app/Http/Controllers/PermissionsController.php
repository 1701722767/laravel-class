<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function index()
    {
        return response()->json(Permission::all(), 200);
    }

    public function show(Permission $permission)
    {
        if (!$permission) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($permission, 200);
    }

    public function store(Request $request)
    {
        try {
            $permission = new Permission();
            $permission->fill($request->all());
            $permission->save();

            return response()->json($permission, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function update(Permission $permission, Request $request)
    {
        try {
            $permission->update($request->all());

            return response()->json($permission, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

}
