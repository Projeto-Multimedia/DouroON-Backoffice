<?php

namespace App\Http\Controllers;

use App\Models\UserFollowers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserFollowersController extends Controller
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

    //create follower by enduser id and profile account id
    public function createFollower(Request $request)
    {

        $follower = new UserFollowers();
        $follower->account_loggedIn_id = $request->accountLoggedIn_id;
        $follower->account_id = $request->profile_id;

        $checkFollower = UserFollowers::where('account_loggedIn_id', $follower->account_loggedIn_id)
            ->where('account_id', $follower->account_id)
            ->first();

        if ($checkFollower) {
            $checkFollower->delete();
            return response()->json([
                'message' => 'You have unfollowed this user',
                'status' => 200,
                'isfollowing' => false
            ]);
        }
        else if ($follower->account_loggedIn_id != $follower->account_id) {
            $follower->save();
            return response()->json([
                'status' => 200,
                'message' => 'You are now following this user',
                'isfollowing' => true
            ], 200);
        } 
        else {
            return response()->json([
                'status' => 400,
                'message' => 'You cannot follow yourself',
            ], 400);
        }    
    }


    public function getFollowers($id)
    {
        $followers = UserFollowers::where('account_id', $id)->get();
        return response()->json([
            'status' => 200,
            'followers' => $followers
        ], 200);
    }


    public function getFollowing($id)
    {
        $following = UserFollowers::where('account_loggedIn_id', $id)->get();
        return response()->json([
            'status' => 200,
            'following' => $following
        ], 200);
    }


    public function deleteFollower(Request $request)
    {
        $follower = UserFollowers::where('account_loggedIn_id', $request->accountLoggedIn_id)
            ->where('account_id', $request->profile_id)
            ->first();

        if ($follower) {
            $follower->delete();
            return response()->json([
                'status' => 200,
                'message' => 'You are no longer following this user',
            ], 200);
        }
    }
    
}
