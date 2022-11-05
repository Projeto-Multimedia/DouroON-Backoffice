<?php

namespace App\Http\Controllers;

use App\Models\EndUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

class EndUserController extends Controller
{
    public function index()
    {
        return EndUser::get();
    }

    public function register()
    {
        return EndUser::create([
            'email' => request('email'),
            'username' => request('username'),
            'name' => request('name'),
            'password' => Hash::make(request('password')),
            'token' => Hash::make(Str::random(16)),
        ]);
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
}
