<?php

namespace App\Http\Controllers;

use App\Models\UserPost;
use App\Models\UserPostLikes;
use App\Models\UserPostComments;
use App\Models\EndUser;
use App\Models\ProfileAccount;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserPostsController extends Controller
{
    public function getFollowingPosts($user_id)
    {

        $profile = ProfileAccount::where('end_user_id', $user_id)->get();
        if ($profile->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Profile does not exist',
            ], 404);
        }

        
        $following = DB::table('user_followers')->where('account_loggedIn_id', $profile[0]->id)->get();

        if ($following->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'You are not following anyone',
            ], 404);
        }
        
        
        $followingIds = [];
        $userInfos = [];
        foreach ($following as $follow) {
            array_push($followingIds, $follow->account_id);
            $endUser = ProfileAccount::where('id', $follow->account_id)->pluck('end_user_id');
            array_push($userInfos, EndUser::select('id', 'avatar', 'username', 'name')->where('id', $endUser[0])->get());
        }

        //Get User Logged In Posts Aswell
        array_push ($followingIds, $profile[0]->id);
        array_push($userInfos, EndUser::select('id', 'avatar', 'username', 'name')->where('id', $user_id)->get());

        
        $posts = UserPost::where('is_approved', 1)->whereIn('profile_id', $followingIds)->get();
        $posts = $posts->sortByDesc('created_at');

        $postLikes = [];
        foreach ($posts as $post) {
            $likes = UserPostLikes::where('post_id', $post->id)->get();
            $countlikes = count($likes);
            array_push($postLikes, $countlikes);
        }

        $postComments = [];
        foreach ($posts as $post) {
            $comments = UserPostComments::where('post_id', $post->id)->get();
            $countComments = count($comments);
            array_push($postComments, $countComments);
        }

        if ($posts->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No posts found',
            ], 404);
        }

        $postInfo = [];
        
        foreach ($posts as $post) {
            $post->user_info = $userInfos[array_search($post->profile_id, $followingIds)][0];

            if($postLikes != null){
                $post->likes = $postLikes[array_search($post->id, $posts->pluck('id')->toArray())];
            } 
            else {
                $post->likes = 0;
            }

            if($postComments != null){
                $post->comments = $postComments[array_search($post->id, $posts->pluck('id')->toArray())];
                $post->commentsText = UserPostComments::select('comment')->where('post_id', $post->id)->get();

            } 
            else{
                $post->comments = 0;
                $post->commentsText = [];
            }
            
            array_push($postInfo, $post);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Posts found',
            'data' => $postInfo,
        ], 200);
    }

    public function getPost($id)
    {
        return UserPost::where('id', $id)->where('is_approved', 1)->get();
    }

    public function createPost(Request $request)
    {
        $profileId = $request->route('profile_id');

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
                'status' => 400,
                'message' => $validator->errors()->first(),
            ], 400);
        }

       if($request->hasFile('image')){
           
                $img = $request->hasFile('image');
                $userPost = UserPost::create([
                    'profile_id' => $profileId,
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

}
