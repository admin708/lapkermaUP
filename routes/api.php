<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/posts/store', [App\Http\Controllers\Controller::class, 'store']);
Route::get('/getMapData', [App\Http\Controllers\Controller::class, 'getMapData']);
Route::get('/getMitra', [App\Http\Controllers\Controller::class, 'getMitra']);
Route::get('/getDataKerjasama', [App\Http\Controllers\Controller::class, 'getDataKerjasama']);
