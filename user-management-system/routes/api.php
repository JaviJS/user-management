<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1'], function () {
    Route::middleware('auth.api')->group(function () {
        Route::resource('users', UserController::class, ['except' => ['update', 'store']]);
        Route::post('users/update/{id}', [UserController::class, 'update']);
        Route::post('users/change-password/{id}', [UserController::class, 'changePassword']);
        Route::post('logout', [AuthController::class, 'logOut']);
    });
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/find/list-roles', [UserController::class, 'listRoles']);
    Route::get('users/find/list-status', [UserController::class, 'listStatus']);
    Route::post('login', [AuthController::class, 'logIn']);
});

Route::fallback(function (Request $request) {
    return response()->json(['message' => 'La ruta que intentas acceder no existe.'], 404);
});