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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('/divisions', 'Api\DivisionController')->middleware('auth:api')->except([
    'create', 'edit'
]);
Route::get('/divisions/buscar/{consulta}', 'Api\DivisionController@buscar')->middleware('auth:api');

Route::get('/users/yo', 'Api\UserController@yo')->middleware('auth:api');
Route::resource('/users', 'Api\UserController')->middleware('auth:api')->except([
    'create', 'edit'
    ]);;
Route::get('/users/{user_id}/reuniones', 'Api\UserController@reuniones')->middleware('auth:api');

Route::get('/users/buscar/{consulta}', 'Api\UserController@buscar')->middleware('auth:api');
Route::get('/users/{user_id}/academiasQueHaPresidido', 'Api\UserController@academiasQueHaPresidido')->middleware('auth:api');

Route::resource('/academias', 'Api\AcademiaController')->middleware('auth:api')->except([
    'create', 'edit'
]);
Route::get('/academias/{academia_id}/acuerdosPendientes', 'Api\AcademiaController@acuerdosPendientes')->middleware('auth:api');

Route::post('/reuniones/crearPDFOrdenDelDia', 'Api\ReunionesController@crearPDFOrdenDelDia')->middleware('auth:api');
Route::resource('/reuniones', 'Api\ReunionesController')->middleware('auth:api')->except([
    'create', 'edit'
]);

Route::fallback(function(){
    return response()->json(['message' => '¡No se encontró el recurso! Verifica la url'], 404);
});
