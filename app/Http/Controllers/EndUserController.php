<?php

namespace App\Http\Controllers;

use App\Models\EndUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
}
