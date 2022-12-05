<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json(Role::all(), 200);
    }

    public function show(Role $role)
    {
        if (!$role) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $role->permissions;

        return response()->json($role, 200);
    }

    public function store(Request $request)
    {
        try {
            $role = new Role();
            $role->fill($request->all());
            $role->save();

            return response()->json($role, 201);
        } catch (\Throwable$th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function addPermissions(Role $role, Request $request)
    {
        try {

            $role->permissions()->attach($request->permission_id);
            $role->permissions;

            return response()->json($role, 201);
        } catch (\Throwable$th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function update(Role $role, Request $request)
    {
        try {
            $role->update($request->all());

            return response()->json($role, 200);
        } catch (\Throwable$th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();

            return response()->json(null, 204);
        } catch (\Throwable$th) {
            return response()->json(['message' => 'Internal Error'], 500);
        }
    }
}
