<?php

namespace App\Http\Controllers;

use App\Models\CompanyPost;
use App\Models\EndUser;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyPostsController extends Controller
{
    public function index()
    {
        return CompanyPost::get();
    }

    public function getPost($id)
    {
        return CompanyPost::where('id', $id)->get();
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
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

       if($request->hasFile('image')){
           
                $img = 'uploads/companyposts/' . time() . '.' . $request->file('image')->extension();
                $request->file('image')->move(public_path('uploads/CompanyPosts'), $img);
                $CompanyPost = CompanyPost::create([
                    'enduser_id' => $userId,
                    'image' => $img,
                    'description' => request('description'),
                    'location' => request('location'),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Post created successfully',
                    'data' => $CompanyPost,
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
