<?php

namespace App\Http\Controllers;

use App\Models\CompanyPlaces;
use Illuminate\Http\Request;
use App\Models\ProfileAccount;
use App\Models\EndUser;

class CompanyPlacesController extends Controller
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

    //get place from location

    public function getPlaceByLocation($location)
    {
         $place = CompanyPlaces::where('location', 'LIKE', '%'.$location.'%')->get();

         if($place->isEmpty()){
             return response()->json([
                 'status' => 404,
                 'message' => 'Place does not exist',
             ], 404);
         }

         $company = EndUser::select('name')->where('profile_id', $place[0]->profile_id)->get();
         
         if($company->isEmpty()){
             return response()->json([
                 'status' => 404,
                 'message' => 'Company does not exist',
             ], 404);
         }

         $placeInfo = [
             'place' => $place[0],
             'company' => $company[0],
         ];
         
            return response()->json([
                'status' => 200,
                'message' => 'Place found',
                'data' => $placeInfo,
            ], 200);
        }
        
}
