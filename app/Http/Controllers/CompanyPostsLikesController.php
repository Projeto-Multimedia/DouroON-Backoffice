<?php

namespace App\Http\Controllers;

use App\Models\CompanyPostsLikes;
use Illuminate\Http\Request;

class CompanyPostsLikesController extends Controller
{
    public function giveLikeAndUnlike(Request $request)
    {
        $like = new CompanyPostsLikes();
        $like->post_id = $request->post_id;
        $like->profile_id = $request->profile_id;

        $check = CompanyPostsLikes::where('post_id', $request->post_id)->where('profile_id', $request->profile_id)->get();

        if ($check->isEmpty()) {

            $like->save();
            return response()->json([
                'status' => 200,
                'message' => 'Post liked',
            ], 200);

        } else {

            $like = CompanyPostsLikes::where('post_id', $request->post_id)->where('profile_id', $request->profile_id)->delete();
        
            return response()->json([
                'message' => 'Like removed successfully',
                'like' => $like
            ], 201);
        }
    }
}
