<?php

namespace App\Http\Controllers;

use App\Models\CompanyFollowers;
use Illuminate\Http\Request;

class CompanyFollowersController extends Controller
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

    public function createFollower(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required',
            'account_loggedIn_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Bad request',
                'data' => $validator->errors(),
            ], 400);
        }

        $follower = new CompanyFollowers();
        $follower->account_loggedIn_id = $request->accountLoggedIn_id;
        $follower->account_id = $request->profile_id;

        $checkFollower = CompanyFollowers::where('account_loggedIn_id', $follower->account_loggedIn_id)
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
        $followers = CompanyFollowers::where('account_id', $id)->get();
        return response()->json([
            'followers' => $followers
        ], 200);
    }


    public function getFollowing($id)
    {
        $following = CompanyFollowers::where('account_loggedIn_id', $id)->get();
        return response()->json([
            'following' => $following
        ], 200);
    }


    public function deleteFollower(Request $request)
    {
        $follower = CompanyFollowers::where('account_loggedIn_id', $request->accountLoggedIn_id)
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
