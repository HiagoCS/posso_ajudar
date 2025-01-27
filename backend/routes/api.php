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
Route::middleware('auth:sanctum')->
    prefix('cashier')->group(function(){
        Route::post("/sale", 'App\Http\Controllers\Cashier\SaleController@insert');
        Route::prefix('get')->group(function(){
            Route::get("/payments", 'App\Http\Controllers\Cashier\SaleController@getPayments');
            Route::get("/clients", 'App\Http\Controllers\Cashier\SaleController@getClients');
        });
    });
Route::middleware('auth:sanctum')->
    prefix('manager')->group(function(){
        Route::prefix('products')->group(function(){
            Route::get('/{index}/{perpage}', 'App\Http\Controllers\Products\StorageController@index');
            Route::post('/insert', 'App\Http\Controllers\Products\StorageController@insert');
            Route::post('/update/{id}', 'App\Http\Controllers\Products\StorageController@update');
            Route::delete('/delete/{id}', 'App\Http\Controllers\Products\StorageController@delete');

            Route::get('/search/{term}/{search}', 'App\Http\Controllers\Products\StorageController@search');
            Route::prefix('stock')->group(function(){
                Route::get('/{id}/{index}/{perpage}', 'App\Http\Controllers\Products\StorageController@stock');
            });
        });
    });
    
Route::get('/theroute', function(Request $request){
    return "HELLO WORLD";
})->middleware("roles");

Route::post('/store', 'App\Http\Controllers\User\AccountController@store');
Route::post('/login', 'App\Http\Controllers\User\AccountController@login');