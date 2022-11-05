<?php

use App\Http\Controllers\EndUserController;
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

Route::group(['prefix' => 'end-users'], function () {
    Route::post('/register', [EndUserController::class, 'register']);
    Route::get('/', [EndUserController::class, 'index']);
    Route::post('/user', [EndUserController::class, 'User']);
    Route::get('/{id}', [EndUserController::class, 'getUser']);
});
