<?php

namespace App\Http\Controllers;

use App\Models\CompanyPost;
use App\Models\EndUser;
use App\Models\CompanyPostsLikes;
use App\Models\ProfileAccount;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyPostsController extends Controller
{
    public function allCompanyPosts()
    {
        $posts = CompanyPost::get();

        if ($posts->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No posts found',
            ], 404);
        }

        //get the info from the user who created the post
        $userInfos = [];
        foreach ($posts as $post) {
            $endUser = ProfileAccount::where('id', $post->profile_id)->pluck('end_user_id');
            array_push($userInfos, EndUser::select('id', 'avatar', 'username', 'name', 'profile')->where('id', $endUser[0])->get());
        }

        $postLikes = [];
        foreach ($posts as $post) {
            $likes = CompanyPostsLikes::where('post_id', $post->id)->get();
            $countlikes = count($likes);
            array_push($postLikes, $countlikes);
        }

        $posts->map(function ($post, $key) use ($userInfos) {
            $post->user_info = $userInfos[$key][0];
        });
        
        $posts->map(function ($post, $key) use ($postLikes) {
            $post->likes = $postLikes[$key];
        });

        return response()->json([
            'status' => 200,
            'message' => 'Posts found',
            'data' => $posts,
        ], 200);
    }

    public function getPost($id)
    {
        return CompanyPost::where('id', $id)->get();
    }

    public function createPost(Request $request)
    {
        $profileId = $request->profile_id;

        $validation = Validator::make(['id' => $profileId], [
            'id' => 'required|exists:profile_accounts,id',
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
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

       if($request->hasFile('image')){
           
                $img = $request->hasFile('image');
                $companyPost = CompanyPost::create([
                    'profile_id' => $profileId,
                    'image' => $img,
                    'description' => request('description'),
                    'location' => request('location'),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Post created successfully',
                    'data' => $companyPost,
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
        
        $post = CompanyPost::where('id', $id)->first();

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
        $post = CompanyPost::where('id', $id)->first();

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
