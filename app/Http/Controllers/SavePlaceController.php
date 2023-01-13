<?php

namespace App\Http\Controllers;

use App\Models\SavePlace;
use App\Models\CompanyPlaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SavePlaceController extends Controller
{
    
    public function savePlace(Request $request)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'place_id' => 'required|exists:company_places,id',
            'route_id' => 'required|exists:user_routes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $savePlace = new SavePlace();

        // Check if the place is already saved in the route
        $check = SavePlace::where('profile_id', $request->profile_id)
        ->where('place_id', $request->place_id)
        ->where('route_id', $request->route_id)
        ->first();

        if($check){
            return response()->json([
                'status' => 400,
                'message' => 'This place is already saved in this route',
            ], 400);
        }
        $savePlace->profile_id = $request->profile_id;
        $savePlace->place_id = $request->place_id;
        $savePlace->route_id = $request->route_id;
        $savePlace->save();
        return response()->json([
            'status' => 200,
            'message' => 'You have successfully saved this place in this route',
        ], 200);
    }


    public function getSavedPlaces(Request $request)
    {
        $routeId = $request->route('id');

        $validation = Validator::make(['id' => $routeId], [
            'id' => 'required|exists:user_routes,id',
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        $savedPlaces = SavePlace::select('place_id')->where('route_id', $routeId)->get();
        
        $placeInfo = CompanyPlaces::select('id', 'name', 'location')->whereIn('id', $savedPlaces)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Saved places found',
            'data' => $placeInfo,
        ], 200);
    }
}
