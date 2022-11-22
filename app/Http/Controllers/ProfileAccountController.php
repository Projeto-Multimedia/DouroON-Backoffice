<?php

namespace App\Http\Controllers;

use App\Models\ProfileAccount;
use App\Models\EndUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProfileAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function getProfileAccounts()
    {
        return ProfileAccount::get();
    }

    public function getProfileAccount($id)
    {

        $profileAccount = ProfileAccount::where('id', $id)->get();

        if ($profileAccount->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Profile account does not exist',
            ], 404);
        }

        return $profileAccount;
    }


    public function getProfileAccountByUsername($username)
    {
        $endUser = EndUser::where('username', $username)->get();

        if ($endUser->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'End user does not exist',
            ], 404);
        }

        $profileAccount = ProfileAccount::where('end_user_id', $endUser[0]->id)->get();

        if ($profileAccount->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Profile account does not exist',
            ], 404);
        }

        return $profileAccount;
    }
    
    public function getEndUser($id)
    {
        $profileAccount = ProfileAccount::where('id', $id)->get();

        if ($profileAccount->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Profile account does not exist',
            ], 404);
        }
        
        $endUser = EndUser::where('id', $profileAccount[0]->end_user_id)->get();

        if ($endUser->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'End user does not exist',
            ], 404);
        }

        return $endUser[0];
    }

    
}
