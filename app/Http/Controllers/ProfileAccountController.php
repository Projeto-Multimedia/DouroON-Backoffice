<?php

namespace App\Http\Controllers;

use App\Models\ProfileAccount;
use App\Models\EndUser;
use App\Models\CompanyPost;
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

    //get profile from user logged in
    public function getUserLoggedInProfile(Request $request)
    {
        $userId = $request->route('user_id');
        $profile = ProfileAccount::where('end_user_id', $userId)->get()->pluck('id');
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $profile[0],
        ], 200);  
    }
    public function getProfileAccounts()
    {
        return ProfileAccount::get();
    }

    public function getSingleProfileAccount($id)
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


    public function getProfileAccountByUsername($username, $accountLoggedIn_id)
    {

        $endUser = EndUser::where('username', 'LIKE', '%' . $username . '%')->get();

        if ($endUser->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Username does not exist',
            ], 404);
        }


        $endUserIds = $endUser->pluck('id');

        $profileAccounts = ProfileAccount::select('id', 'end_user_id')->where('id', '!=', $accountLoggedIn_id)->whereIn('end_user_id', $endUserIds)->get();

        if ($profileAccounts->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Profile account does not exist',
            ], 404);
        } 

        $userInfo = $profileAccounts->map(function ($profileAccount) {
            $user = EndUser::select('id', 'name', 'username', 'avatar', 'profile')->where('id', $profileAccount->end_user_id)->get();
            $profileAccount->endUser = $user[0];
            return $profileAccount;
        });

        return response()->json([
            'status' => 200,
            'message' => 'Profile account found',
            'data' =>  $userInfo,
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
        
        $endUser = EndUser::select('avatar', 'name', 'username', 'profile')->where('id', $profileAccount[0]->end_user_id)->get();

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

        $userPosts = UserPost::where('profile_id', $id)->where('is_approved', 1)->get();

        $numberOfPosts = count($userPosts);


        $followers = $profileAccount[0]->followers()->get();
        $numberOfFollowers = count($followers);

        $following = $profileAccount[0]->following()->get();
        $numberOfFollowing = count($following);

        
        return response()->json([
            'status' => 200,
            'message' => 'User posts retrieved successfully',
            'data' => [
                'profileAccount' => $profileAccount[0],
                'endUser' => $endUser[0],
                'numberOfPosts' => $numberOfPosts,
                'numberOfFollowers' => $numberOfFollowers,
                'numberOfFollowing' => $numberOfFollowing,
                'posts' => $userPosts,
            ],
        ], 200);

    }

    public function getCompanyProfileInfo($id)
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

        $companyPosts = CompanyPost::where('profile_id', $id)->get();

        $numberOfPosts = count($companyPosts);

        $followers = $profileAccount[0]->Companyfollowers()->get();
        $numberOfFollowers = count($followers);

        $following = $profileAccount[0]->Companyfollowing()->get();
        $numberOfFollowing = count($following);
        
        return response()->json([
            'status' => 200,
            'message' => 'Company posts retrieved successfully',
            'data' => [
                'profileAccount' => $profileAccount[0],
                'endUser' => $endUser[0],
                'numberOfFollowers' => $numberOfFollowers,
                'numberOfFollowing' => $numberOfFollowing,
                'numberOfPosts' => $numberOfPosts,
                'posts' => $companyPosts,
            ],
        ], 200);

    }
    
}
