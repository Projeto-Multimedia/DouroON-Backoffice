<?php

namespace App\Http\Controllers;

use App\Models\EndUser;

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
            'password' => request('password'),
        ]);
    }
}
