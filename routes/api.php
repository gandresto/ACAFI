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

// ----------- Rutas para Divisiones -------------
Route::apiResource('/divisions', 'Api\DivisionController')->middleware('auth:api');
Route::get('/divisions/buscar/{consulta}', 'Api\DivisionController@buscar')->middleware('auth:api');

// ----------- Rutas para Usuario -------------
Route::apiResource('users', 'Api\UserController')->middleware('auth:api');
Route::apiResource('users.reuniones', 'Api\UserReunionesController')->middleware('auth:api');
Route::apiResource('users.academiasQueHaPresidido', 'Api\UserAcademiasQueHaPresididoController')->middleware('auth:api');

// ----------- Rutas para usuario autenticado -------------
Route::apiResource('/perfil/reuniones', 'Api\PerfilReunionesController')->middleware('auth:api');
// Route::apiResource('/perfil/presidencia/academias', 'Api\PerfilReunionesController')->middleware('auth:api');
// Route::apiResource('perfil', 'Api\PerfilController')->middleware('auth:api');


// ----------- Rutas para Academias -------------
Route::apiResource('/academias', 'Api\AcademiaController')->middleware('auth:api');
Route::apiResource('academias.acuerdos', 'Api\AcademiaAcuerdoController')->middleware('auth:api');

// ----------- Rutas para Reuniones -------------
Route::post('/reuniones/crearPDFOrdenDelDia', 'Api\ReunionesController@crearPDFOrdenDelDia')->middleware('auth:api');
Route::apiResource('/reuniones', 'Api\ReunionesController')->middleware('auth:api');
Route::apiResource('reuniones.minuta', 'Api\ReunionesMinutaController')->middleware('auth:api')->except('show');
// Route::get('/reuniones/{reunion_id}/actualizarPDFOrdenDelDia', 'Api\ReunionesController@actualizarPDFOrdenDelDia')->middleware('auth:api');


// ---------- Rutas para grados
Route::apiResource('/grados', 'Api\GradosController')->middleware('auth:api');

Route::fallback(function(){
    return response()->json(['message' => '¡No se encontró el recurso! Verifica la url'], 404);
});
