<?php

namespace App\Http\Controllers;

use App\Models\UserRoutes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRoutesController extends Controller
{

    public function getRoute(Request $request)
    {
        $routeId = $request->route('id');

        $validation = Validator::make(['id' => $routeId], [
            'id' => 'required|exists:user_routes,id',
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        $route = UserRoutes::find($routeId);

        return response()->json([
            'status' => 200,
            'message' => 'Route found',
            'route' => $route,
        ], 200);
    }

    public function getUserRoutes(Request $request)
    {
        $profileId = $request->route('profile_id');

        $validation = Validator::make(['id' => $profileId], [
            'id' => 'required|exists:profile_accounts,id',
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        $routes = UserRoutes::where('profile_id', $profileId)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Routes found',
            'routes' => $routes,
        ], 200);
    }

    public function createUserRoute(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'route_name' => 'required|min:1|max:70',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        $route = new UserRoutes();
        $route->profile_id = $request->profile_id;
        $route->route_name = $request->route_name;

        $route->save();

        return response()->json([
            'status' => 200,
            'message' => 'Route created successfully',
            'route' => $route,
        ], 200);
    }

    public function deleteUserRoute(Request $request)
    {
        $routeId = $request->route('id');

        $validation = Validator::make(['id' => $routeId], [
            'id' => 'required|exists:user_routes,id',
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        $route = UserRoutes::find($routeId);
        $route->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Route deleted successfully',
        ], 200);
    }


}
