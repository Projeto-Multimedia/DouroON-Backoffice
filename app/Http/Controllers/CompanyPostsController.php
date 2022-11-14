<?php

namespace App\Http\Controllers;

use App\Models\CompanyPost;
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

        $post = CompanyPost::create([
            'image' => $request->get('image'),
            'description' => $request->get('description'),
            'location' => $request->get('location'),
            'enduser_id' => $user_id,
        ]);

        return response()->json($post, 201);
    }
    
}
