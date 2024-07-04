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
    return ['user' => $request->user(), 'roles_nm' => $request->user()->getRoleNames()];
});
Route::post('/store', 'App\Http\Controllers\User\AccountController@store');
Route::post('/login', 'App\Http\Controllers\User\AccountController@login');