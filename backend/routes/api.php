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

Route::middleware('auth:sanctum')->prefix('user')->group(function(){
    Route::get('/', function (Request $request) {
        return $request->user();
    });
    Route::get('/roles', function (Request $request) {
        return $request->user()->getRoleNames();
    });
});
Route::get('/theroute', function(Request $request){
    return "HELLO WORLD";
})->middleware("roles");

Route::post('/store', 'App\Http\Controllers\User\AccountController@store');
Route::post('/login', 'App\Http\Controllers\User\AccountController@login');