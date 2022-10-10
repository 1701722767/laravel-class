<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PermissionsController::class)->group(function () {
    Route::get('permissions', 'index');
    Route::get('permissions/{permission}', 'show');
    Route::delete('permissions/{permission}', 'destroy');
    Route::post('permissions', 'store');
    Route::put('permissions/{permission}', 'update');
});

Route::controller(RoleController::class)->group(function () {
    Route::get('roles', 'index');
    Route::get('roles/{role}', 'show');
    Route::delete('roles/{role}', 'destroy');
    Route::post('roles', 'store');
    Route::put('roles/{role}', 'update');
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('profiles', 'index');
    Route::get('profiles/{profile}', 'show');
    Route::delete('profiles/{profile}', 'destroy');
    Route::post('profiles', 'store');
    Route::put('profiles/{profile}', 'update');
});

Route::controller(UsersController::class)->group(function () {
    // Route::get('users', 'index');
    // Route::get('users/{user}', 'show');
    // Route::delete('users/{user}', 'destroy');
    Route::post('users', 'store');
    // Route::put('users/{user}', 'update');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});
