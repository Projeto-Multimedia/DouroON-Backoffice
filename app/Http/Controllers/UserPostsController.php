<?php

namespace App\Http\Controllers;

use App\Models\UserPost;
use App\Models\EndUser;
use App\Models\ProfileAccount;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserPostsController extends Controller
{
    public function index()
    {
        return UserPost::where('is_approved', 1)->get();
    }

    public function getPost($id)
    {
        return UserPost::where('id', $id)->where('is_approved', 1)->get();
    }

    public function createPost(Request $request)
    {
        $userId = $request->route('user_id');

        $validation = Validator::make(['id' => $userId], [
            'id' => 'required|exists:end_users,id',
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        $validator = Validator::make(request()->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'max:255',
            'location' => 'max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ], 400);
        }

       if($request->hasFile('image')){
           
                $img = $request->hasFile('image');
                $userPost = UserPost::create([
                    'enduser_id' => $userId,
                    'image' => $img,
                    'description' => request('description'),
                    'location' => request('location'),
                ]);

                return response()->json([
                    'status' => 201,
                    'message' => 'Post created successfully',
                    'data' => $userPost,
                ], 201);
         }
    }
    

    public function updatePost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'max:255',
            'location' => 'max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $post = UserPost::where('id', $id)->first();

        if ($post) {
            $post->update([
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

    public function getUserInfoByPost($id)
    {
        $post = UserPost::where('id', $id)->where('is_approved', 1)->get();

        if ($post->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Post does not exist',
            ], 404);
        }

        $user = EndUser::select('username', 'avatar', 'name')->where('id', $post[0]->enduser_id)->get();

        if ($user->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'User does not exist',
            ], 404);
        }   

        $profileAccount = ProfileAccount::select('id')->where('end_user_id', $post[0]->enduser_id)->get();

        if ($profileAccount->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Profile account does not exist',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Post, user and profile account retrieved successfully',
            'data' => [
                'post' => $post[0],
                'user' => $user[0],
                'profile_account' => $profileAccount[0],
            ],
        ], 200);
    }

}
