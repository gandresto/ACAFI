<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/calendario', 'CalendarioController@index')->name('calendario');

// -------- USUARIOS ---------
Auth::routes();
Route::resource('users', 'UsersController');
Route::get('/users/buscar/{consulta}', 'UsersController@buscar')->name('users.buscar');

// -------- PERFIL --------
Route::get('perfil', 'PerfilController@index')->name('perfil.index')->middleware('auth');

// ----- DIVISIONES -------
Route::resource('divisions', 'DivisionController');
Route::get('/divisions/buscar/{consulta}', 'DivisionController@buscar')->name('divisions.buscar');

// ------- DEPARTAMENTOS -------
Route::resource('divisions.departamentos', 'DivisionDepartamentoController');
Route::resource('departamentos', 'DepartamentosController');

// ------- ACADEMIAS --------
Route::resource('divisions.departamentos.academias', 'DivisionDepartamentoAcademiaController');
Route::get('/divisions/{division}/departamentos/{departamento}/academias/{academia}/miembros/agregar', 'DivisionDepartamentoAcademiaController@agregarMiembro')
        ->name('divisions.departamentos.academias.agregar-miembro');
Route::delete('/divisions/{division}/departamentos/{departamento}/academias/{academia}/miembros/{miembro}', 'DivisionDepartamentoAcademiaController@darDeBajaMiembro')
        ->name('divisions.departamentos.academias.darDeBajaMiembro');

// ------ REUNIONES -----------
Route::resource('academias.reuniones', 'AcademiaReunionesController')
        ->except(['store', 'update', 'destroy'])
        ->middleware('auth');
Route::resource('/reuniones', 'ReunionesController')
        ->except(['store', 'update', 'destroy']);
Route::get('/reuniones/{id}/orden-del-dia', 'ReunionesController@descargarOrdenDelDia')
        ->name('reuniones.ordendeldia.descargar');
Route::get('/reuniones/{id}/emailpreview', 'ReunionesController@emailPreview');
Route::get('/reuniones/{reunion}/vista-previa-od', function (App\Reunion $reunion){
    $pdf = \PDF::loadView('reuniones.ordendeldia', ['reunion' => $reunion]);
    return $pdf->stream();
    // return view('reuniones.ordendeldia', compact('reunion'));
});

// --------- MINUTAS --------------
Route::resource('reuniones.minuta', 'ReunionesMinutasController')
        ->only(['index', 'create']);
Route::get('/reuniones/{reunion}/minuta/vista-previa/', function (App\Reunion $reunion){
    $pdf = \PDF::loadView('reuniones.pdf.minuta', ['reunion' => $reunion]);
    return $pdf->stream();
});