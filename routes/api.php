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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//AUTO api prefixed
Route::prefix('account')->group(function () { 
    Route::post('login', 'Rest\RestAccountController@login');
});

Route::prefix('public')->group(function () { 
    Route::post('pagecode', 'Rest\PublicController@pageCode');
});

Route::prefix('entity')->group(function () { 
    Route::post('get', 'Rest\RestEntityController@get_entity');
    Route::post('add', 'Rest\RestEntityController@add_entity');
    Route::post('update', 'Rest\RestEntityController@update_entity');
});


