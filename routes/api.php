<?php

use Illuminate\Http\Request;

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

Route::resource('/divisions', 'Api\DivisionController')->middleware('auth:api');
Route::get('/divisions/buscar/{consulta}', 'Api\DivisionController@buscar')->middleware('auth:api');

Route::resource('users/', 'Api\UserController')->middleware('auth:api');;
Route::get('users/buscar/{consulta}', 'Api\UserController@buscar')->middleware('auth:api');;

Route::fallback(function(){
    return response()->json(['message' => '¡No se encontró el recurso!'], 404);
});
