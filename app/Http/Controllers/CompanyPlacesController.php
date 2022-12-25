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

         $placeInfo = $company->map(function ($item, $key) use ($place) {
            return [
                'company_name' => $item->name,
                'id' => $place[0]->id,
                'name' => $place[0]->name,
                'location' => $place[0]->location,
                'image' => $place[0]->image,
            ];    
        });
         
            return response()->json([
                'status' => 200,
                'message' => 'Place found',
                'data' => $placeInfo,
            ], 200);
        }
        
        //get place by id

        public function getPlaceById($id)
        {
            $place = CompanyPlaces::where('id', $id)->get();

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

            $placeInfo = $company->map(function ($item, $key) use ($place) {
                return [
                    'company_name' => $item->name,
                    'id' => $place[0]->id,
                    'name' => $place[0]->name,
                    'location' => $place[0]->location,
                    'address' => $place[0]->address,
                    'phone' => $place[0]->phone,
                    'email' => $place[0]->email,
                    'description' => $place[0]->description,
                    'image' => $place[0]->image,
                ];    
            });
            
                return response()->json([
                    'status' => 200,
                    'message' => 'Place found',
                    'data' => $placeInfo[0],
                ], 200);
            }

        
}
