<?php

namespace App\Http\Controllers;

use App\Models\EndUser;

class EndUserController extends Controller
{
    public function index()
    {
        return EndUser::get();
    }
}
