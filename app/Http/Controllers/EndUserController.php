<?php

namespace App\Http\Controllers;

use App\Models\EndUser;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EndUserController extends Controller
{
    public function index()
    {
        return EndUser::get();
    }

    public function register()
    { 
        $validator = Validator::make(request()->all(), [
            'name' => 'required|min:8|max:70',
            'email' => 'required|email|unique:end_users',
            'password' => 'required|min:9|max:15',
            'username' => 'required|min:6|max:20|unique:end_users',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = EndUser::create([
            'avatar' => request('avatar'),
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'username' => request('username'),
            'token' => Str::random(60),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    public function getUser(Request $request)
    {
        $userId = $request->route('id');

        $validation = Validator::make(['id' => $userId], [
            'id' => 'required|exists:end_users,id',
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        $user = EndUser::find($userId);
        return $user;
    }

    public function userLogIn()
    {
        //sign in request username and password
        $username = request('username');
        $password = request('password');
        //check if username and password is correct
        $user = DB::table('end_users')->where('username', $username)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                //if correct return user data
                return response()->json([
                    'status' => 200,
                    'message' => 'Login success.',
                    'data' => $user,
                ], 200);
            } else {
                //if not correct return error message
                return response()->json([
                    'status' => 401,
                    'message' => 'Login failed, wrong password.',
                ], 401);
            }
        } else {
            //if not correct return error message
            return response()->json([
                'status' => 401,
                'message' => 'Login failed, username not found.',
            ], 401);
        }
    }

    public function updateUserData(Request $request)
    {
        $userId = $request->route('id');

        $validation = Validator::make(['id' => $userId], [
            'id' => 'required|exists:end_users,id',
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        $user = EndUser::find($userId);

        if (request('avatar') != null) {

            
            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            
            $validator = Validator::make($request->all(), [
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $user->avatar = $imageName;
        }

        if (request('name') != null) {

            $validator = Validator::make(request()->all(), [
                'name' => 'min:8|max:70',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $user->name = request('name');
        }

        if (request('username') != null) {

            $validator = Validator::make(request()->all(), [
                'username' => 'min:6|max:20|unique:end_users,username,'.$user->id,
            ]);

            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 400);
            }

            $userCheck = DB::table('end_users')->where('username', request('username'))->first();
            if ($userCheck) {
                if ($userCheck->id != $user->id) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Username already taken.',
                    ], 400);
                }
            }

            $user->username = request('username');
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user,
        ], 200);

    }

    public function uploadImage(Request $request)
    {

        $userId = $request->route('id');

        $validation = Validator::make(['id' => $userId], [
            'id' => 'required|exists:end_users,id',
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        $user = EndUser::find($userId);

        $image = $request->file('avatar');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        $validator = Validator::make($request->all(), [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user->avatar = $imageName;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Image uploaded successfully',
            'data' => $user,
        ], 200);
    }
}
