<?php

use App\Http\Controllers\EndUserController;
use App\Http\Controllers\UserPostsController;
use App\Http\Controllers\CompanyPostsController;
use App\Http\Controllers\ProfileAccountController;
use App\Http\Controllers\UserFollowersController;
use App\Http\Controllers\CompanyFollowersController;
use App\Http\Controllers\UserPostLikesController;
use App\Http\Controllers\CompanyPostsLikesController;
use App\Http\Controllers\UserPostCommentsController;
use App\Http\Controllers\CompanyPlacesController;
use App\Http\Controllers\UserRoutesController;
use App\Http\Controllers\SavePlaceController;
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
    Route::post('/login', [EndUserController::class, 'userLogIn']);
    Route::get('/{id}', [EndUserController::class, 'getUser']);
    Route::post('/{id}/edit', [EndUserController::class, 'updateUserData']);
    Route::post('/{id}/upload', [EndUserController::class, 'uploadImage']);
    Route::post('/{id}/delete', [EndUserController::class, 'deleteUser']);
});

Route::group(['prefix' => 'user-posts'], function () {
    Route::get('/{id}', [UserPostsController::class, 'getPost']);
    Route::get('/{user_id}/follows', [UserPostsController::class, 'getFollowingPosts']);
    Route::post('/{profile_id}/create', [UserPostsController::class, 'createPost']);
    Route::post('/{id}/update', [UserPostsController::class, 'updatePost']);
    Route::get('/{id}/delete', [UserPostsController::class, 'deletePost']);
    Route::post('/{post_id}/{profile_id}/like', [UserPostLikesController::class, 'giveLikeAndUnlike']);
    Route::post('/{post_id}/{profile_id}/comment', [UserPostCommentsController::class, 'createComment']);
});

Route::group(['prefix' => 'company-posts'], function () {
    Route::get('/', [CompanyPostsController::class, 'allCompanyPosts']);
    Route::get('/{id}', [CompanyPostsController::class, 'getPost']);
    Route::post('/{profile_id}/create', [CompanyPostsController::class, 'createPost']);
    Route::post('/{id}/update', [CompanyPostsController::class, 'updatePost']);
    Route::get('/{id}/delete', [CompanyPostsController::class, 'deletePost']);
    Route::post('/{post_id}/{profile_id}/like', [CompanyPostsLikesController::class, 'giveLikeAndUnlike']);
});

Route::group(['prefix' => 'profile-accounts'], function () {
    Route::get('/', [ProfileAccountController::class, 'getProfileAccounts']);
    Route::get('/{user_id}', [ProfileAccountController::class, 'getUserLoggedInProfile']);
    Route::get('/profile/{id}', [ProfileAccountController::class, 'getSingleProfileAccount']);
    Route::get('/{username}/search/{accountLoggedIn_id}', [ProfileAccountController::class, 'getProfileAccountByUsername']);
    Route::get('/{id}/user', [ProfileAccountController::class, 'getUserInfo']);
    Route::get('/{id}/user-profile', [ProfileAccountController::class, 'getUserProfileInfo']);
    Route::get('/{id}/company-profile', [ProfileAccountController::class, 'getCompanyProfileInfo']);
});

Route::group(['prefix' => 'user-followers'], function () {
    Route::get('/{id}', [UserFollowersController::class, 'getFollowers']);
    Route::get('/{id}/following', [UserFollowersController::class, 'getFollowing']);
    Route::post('/{profile_id}/{accountLoggedIn_id}/', [UserFollowersController::class, 'createFollower']);
    Route::get('/{id}/delete', [UserFollowersController::class, 'deleteFollower']);
});

Route::group(['prefix' => 'user-post-comments'], function () {
    Route::get('/{post_id}', [UserPostCommentsController::class, 'getComments']);
    Route::get('/{id}/delete', [UserPostCommentsController::class, 'deleteComment']);
});

Route::group(['prefix' => 'company-places'], function () {
    Route::get('/{location}/search/', [CompanyPlacesController::class, 'getPlaceByLocation']);
    Route::get('/{id}', [CompanyPlacesController::class, 'getPlaceById']);
});

Route::group(['prefix' => 'user-routes'], function () {
    Route::get('/{id}', [UserRoutesController::class, 'getRoute']);
    Route::post('/{profile_id}/create', [UserRoutesController::class, 'createUserRoute']);
    Route::get('/{profile_id}/routes', [UserRoutesController::class, 'getUserRoutes']);
    Route::get('/{id}/delete', [UserRoutesController::class, 'deleteUserRoute']);
});

Route::group(['prefix' => 'save-places'], function () {
    Route::post('/{profile_id}/save', [SavePlaceController::class, 'savePlace']);
    Route::get('/{id}/saved', [SavePlaceController::class, 'getSavedPlaces']);
});
    
