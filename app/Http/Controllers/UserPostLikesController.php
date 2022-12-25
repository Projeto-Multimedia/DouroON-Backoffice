<?php

namespace App\Http\Controllers;

use App\Models\UserPostLikes;
use Illuminate\Http\Request;

class UserPostLikesController extends Controller
{

    public function giveLikeAndUnlike(Request $request)
    {
        $like = new UserPostLikes();
        $like->post_id = $request->post_id;
        $like->profile_id = $request->profile_id;

        $totalLikes = UserPostLikes::where('post_id', $request->post_id)->count();
        $check = UserPostLikes::where('post_id', $request->post_id)->where('profile_id', $request->profile_id)->get();

        if ($check->isEmpty()) {

            $like->save();
            return response()->json([
                'status' => 200,
                'message' => 'Post liked',
                'isLiked' => true,
            ], 200);

        } else {

            $like = UserPostLikes::where('post_id', $request->post_id)->where('profile_id', $request->profile_id)->delete();
        
            return response()->json([
                'status' => 201,
                'message' => 'Like removed successfully',
                'isLiked' => false,
            ], 201);
        }
    }
}
