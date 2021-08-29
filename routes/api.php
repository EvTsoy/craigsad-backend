<?php

use App\Http\Controllers\Api\v1\AdController;
use App\Http\Controllers\Api\v1\AuthController;
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

//Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

//Common routes
Route::apiResource('ads', AdController::class)
    ->only('index', 'show');



//Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('ads', AdController::class)
        ->only('store', 'update', 'destroy');
    Route::get('user', [AuthController::class, 'user']);
});
