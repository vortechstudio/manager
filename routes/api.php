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

Route::prefix('services')->group(function () {
    Route::get('/', function (Request $request) {
        if ($request->has('service_name')) {
            return response()->json(\App\Models\Config\Service::with('versions', 'tickets', 'shop', 'cercle')->where('name', 'like', '%'.$request->get('service_name').'%')->first());
        } else {
            return response()->json(\App\Models\Config\Service::all());
        }
    });

    Route::get('{id}', function (int $id) {
        $service = \App\Models\Config\Service::with('versions', 'tickets', 'shop', 'cercle')->find($id);
        return response()->json($service);
    });

    Route::get('{id}/articles', function (int $id) {
        $service = \App\Models\Config\Service::with('versions', 'tickets', 'shop', 'cercle')->find($id);
        $articles = \App\Models\Social\Article::where('cercle_id', $service->cercle_id)
            ->where('published', 1)
            ->where('status', 'published')
            ->where('type', 'news')
            ->orWhere('type', 'notice')
            ->get();
        return response()->json($articles);
    });
});

Route::prefix('support')->group(function () {

});
