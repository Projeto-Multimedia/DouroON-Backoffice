<?php

namespace App\Http\Controllers;

use App\Models\ProfileAccount;
use App\Models\EndUser;
use App\Models\UserPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProfileAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function getProfileAccounts()
    {
        return ProfileAccount::get();
    }

    public function getProfileAccount($id)
    {

        $profileAccount = ProfileAccount::where('id', $id)->get();

        if ($profileAccount->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Profile account does not exist',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Profile account found',
            'data' => $profileAccount[0],
        ], 200);
    }


    public function getProfileAccountByUsername($username)
    {
        $endUser = EndUser::where('username', $username)->get();

        if ($endUser->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'End user does not exist',
            ], 404);
        }

        $profileAccount = ProfileAccount::where('end_user_id', $endUser[0]->id)->get();

        if ($profileAccount->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Profile account does not exist',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Profile account found',
            'data' => $profileAccount[0],
        ], 200);
    }

    //Info for the search
    public function getUserInfo($id)
    {
        $profileAccount = ProfileAccount::where('id', $id)->get();

        if ($profileAccount->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Profile account does not exist',
            ], 404);
        }
        
        $endUser = EndUser::select('avatar', 'name', 'username')->where('id', $profileAccount[0]->end_user_id)->get();

        if ($endUser->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'End user does not exist',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'User info retrieved successfully',
            'data' => $endUser[0],
        ], 200);
    }

    public function getUserProfileInfo($id)
    {
        $profileAccount = ProfileAccount::select('id', 'biography', 'end_user_id')->where('id', $id)->get();

        if ($profileAccount->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Profile account does not exist',
            ], 404);
        }

        $endUser = EndUser::select('id','avatar', 'name', 'username', 'profile')->where('id', $profileAccount[0]->end_user_id)->get();

        if ($endUser->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'End user does not exist',
            ], 404);
        }

        $userPosts = UserPost::where('enduser_id', $endUser[0]->id)->where('is_approved', 1)->get();

        if ($userPosts->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'User posts do not exist',
            ], 404);
        }
        //get the number of posts
        $numberOfPosts = count($userPosts);
        
        return response()->json([
            'status' => 200,
            'message' => 'User posts retrieved successfully',
            'data' => [
                'profileAccount' => $profileAccount[0],
                'endUser' => $endUser[0],
                'numberOfPosts' => $numberOfPosts,
                'userPosts' => $userPosts,
            ],
        ], 200);

    }
    
}
