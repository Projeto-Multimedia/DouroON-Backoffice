<?php

use App\Http\Controllers\EndUserController;
use App\Http\Controllers\UserPostsController;
use App\Http\Controllers\CompanyPostsController;
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
    Route::post('/login', [EndUserController::class, 'UserLogIn']);
    Route::get('/{id}', [EndUserController::class, 'getUser']);
    Route::post('/{id}/edit', [EndUserController::class, 'updateUserData']);
});

Route::group(['prefix' => 'user-posts'], function () {
    Route::get('/', [UserPostsController::class, 'index']);
    Route::get('/{id}', [UserPostsController::class, 'getPost']);
    Route::post('/{user_id}/create', [UserPostsController::class, 'createPost']);
    Route::post('/{id}/update', [UserPostsController::class, 'updatePost']);
});

Route::group(['prefix' => 'company-posts'], function () {
    Route::get('/', [CompanyPostsController::class, 'index']);
    Route::get('/{id}', [CompanyPostsController::class, 'getPost']);
    Route::post('/{user_id}/create', [CompanyPostsController::class, 'createPost']);
    Route::post('/{id}/update', [CompanyPostsController::class, 'updatePost']);

});
