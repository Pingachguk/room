<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('clubs', [\App\Http\Controllers\ApiController::class, 'clubs']);
Route::get('club/{id}', [\App\Http\Controllers\ApiController::class, 'club']);
Route::post('login', [\App\Http\Controllers\ApiController::class, 'login']);
Route::post('reg', [\App\Http\Controllers\ApiController::class, 'register']);
Route::get('client', [\App\Http\Controllers\ApiController::class, 'getClient']);
Route::put('client', [\App\Http\Controllers\ApiController::class, 'updateClient']);
Route::post('confirm_phone', [\App\Http\Controllers\ApiController::class, 'confirmPhone']);
Route::post('reset_password', [\App\Http\Controllers\ApiController::class, 'resetPassword']);
Route::get('trainers', [\App\Http\Controllers\ApiController::class, 'getTrainersAll']);


