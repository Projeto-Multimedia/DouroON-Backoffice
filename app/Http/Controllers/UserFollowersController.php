<?php

namespace App\Http\Controllers;

use App\Models\UserFollowers;
use Illuminate\Http\Request;

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
            return response()->json([
                'message' => 'You are already following this user',
            ], 400);
        }
        else if ($follower->account_loggedIn_id != $follower->account_id) {
            $follower->save();
            return response()->json([
                'message' => 'You are now following this user',
                'follower' => $follower
            ], 200);
        } 
        else {
            return response()->json([
                'message' => 'You cannot follow yourself',
            ], 400);
        }    
    }


    public function getFollowers($id)
    {
        $followers = UserFollowers::where('account_id', $id)->get();
        return response()->json([
            'followers' => $followers
        ], 200);
    }


    public function getFollowing($id)
    {
        $following = UserFollowers::where('account_loggedIn_id', $id)->get();
        return response()->json([
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
                'message' => 'You are no longer following this user',
            ], 200);
        }
    }
    
}
