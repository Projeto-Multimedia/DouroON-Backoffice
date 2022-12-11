<?php

namespace App\Http\Controllers;

use App\Models\UserPostComments;
use Illuminate\Http\Request;

class UserPostCommentsController extends Controller
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

    //create comment by profile logged in id and post id
    public function createComment(Request $request)
    {
        $comment = new UserPostComments();
        $comment->post_id = $request->post_id;
        $comment->profile_id = $request->profile_id;
        $comment->comment = $request->comment;

        $comment->save();

        return response()->json([
            'status' => 200,
            'message' => 'Comment created',
            'comment' => $comment
        ], 200);
    }

    public function getComments($post_id)
    {
        $comments = UserPostComments::where('post_id', $post_id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Comments retrieved',
            'comments' => $comments
        ], 200);
    }

    //delete comment
    public function deleteComment($id)
    {
        $comment = UserPostComments::find($id);

        if ($comment) {
            $comment->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Comment deleted',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Comment not found',
            ], 400);
        }
    }
}
