<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/services', function (Request $request) {
    if ($request->has('service_name')) {
        return response()->json(\App\Models\Config\Service::where('name', 'like', '%'.$request->get('service_name').'%')->first());
    } else {
        return response()->json(\App\Models\Config\Service::all());
    }
});
