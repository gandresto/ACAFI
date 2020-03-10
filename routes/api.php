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
// Route::get('/divisions/buscar/{consulta}', 'Api\DivisionController@buscar', ['as' => 'api'])->middleware('auth:api');
Route::apiResource('/divisions', 'Api\DivisionController', ['as' => 'api'])->middleware('auth:api');

// ----------- Rutas para Usuario -------------
Route::apiResource('users.academiasQueHaPresidido', 'Api\UserAcademiasQueHaPresididoController', ['as' => 'api'])->middleware('auth:api');
Route::apiResource('users.reuniones', 'Api\UserReunionesController', ['as' => 'api'])->middleware('auth:api');
Route::apiResource('users', 'Api\UserController', ['as' => 'api'])->middleware('auth:api');

// ----------- Rutas para usuario autenticado -------------
// Route::apiResource('/perfil/reuniones', 'Api\PerfilReunionesController', ['as' => 'api'])->middleware('auth:api');
// Route::apiResource('/perfil/presidencia/academias', 'Api\PerfilReunionesController')->middleware('auth:api');
// Route::apiResource('perfil', 'Api\PerfilController')->middleware('auth:api');


// ----------- Rutas para Academias -------------
Route::apiResource('/academias', 'Api\AcademiaController', ['as' => 'api'])->middleware('auth:api');
Route::apiResource('academias.miembros', 'Api\AcademiaMiembrosController', ['as' => 'api'])->middleware('auth:api');
Route::apiResource('academias.acuerdos', 'Api\AcademiaAcuerdoController', ['as' => 'api'])->middleware('auth:api');

// ----------- Rutas para Reuniones -------------
Route::post('/reuniones/crearPDFOrdenDelDia', 'Api\ReunionesController@crearPDFOrdenDelDia', ['as' => 'api'])->middleware('auth:api');
Route::apiResource('reuniones.minuta', 'Api\ReunionesMinutaController', ['as' => 'api'])->middleware('auth:api')->except('show');
Route::apiResource('/reuniones', 'Api\ReunionesController', ['as' => 'api'])->middleware('auth:api');
// Route::get('/reuniones/{reunion_id}/actualizarPDFOrdenDelDia', 'Api\ReunionesController@actualizarPDFOrdenDelDia')->middleware('auth:api');


// ---------- Rutas para grados
Route::apiResource('grados', 'Api\GradosController', ['as' => 'api'])->middleware('auth:api');

// Route::fallback(abort(404, '¡No se encontró el recurso! Verifica la url'));
