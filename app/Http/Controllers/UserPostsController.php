<?php

namespace App\Http\Controllers;

use App\Models\UserPost;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserPostsController extends Controller
{
    public function index()
    {
        return UserPost::get();
    }

    public function getPost($id)
    {
        return UserPost::where('id', $id)->get();
    }

    public function createPost(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $post = UserPost::create([
            'image' => $request->get('image'),
            'description' => $request->get('description'),
            'location' => $request->get('location'),
            'enduser_id' => $user_id,
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Post created successfully',
            'data' => $post,
        ], 201); 
    }

    public function updatePost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $post = UserPost::where('id', $id)->first();

        if ($post) {
            $post->update([
                'image' => $request->get('image'),
                'description' => $request->get('description'),
                'location' => $request->get('location'),
            ]);
        }
        else {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json([
            'status' => 201,
            'message' => 'Post updated successfully',
            'data' => $post,
        ], 201); 
    }

    public function deletePost($id)
    {
        $post = UserPost::where('id', $id)->first();

        if ($post) {
            $post->delete();
        }
        else {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json([
            'status' => 201,
            'message' => 'Post deleted successfully',
            'data' => $post,
        ], 201); 
    }   
}
