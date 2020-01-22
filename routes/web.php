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

Auth::routes();

Route::get('/calendario', 'HomeController@index')->name('calendario');

// ----- DIVISIONES -------
Route::resource('divisions', 'DivisionController');
Route::get('/divisions/buscar/{consulta}', 'DivisionController@buscar')->name('divisions.buscar');

// ------- DEPARTAMENTOS -------
Route::resource('divisions.departamentos', 'DivisionDepartamentoController');
Route::resource('departamentos', 'DepartamentosController');

// ------- ACADEMIAS --------
Route::post('/divisions/{division}/departamentos/{departamento}/academias/{academia}/{miembro}',
            'DivisionDepartamentoAcademiaController@darDeBajaMiembro')
                ->name('divisions.departamentos.academias.darDeBajaMiembro');
Route::get('/divisions/{division}/departamentos/{departamento}/academias/{academia}/agregar-miembro',
            'DivisionDepartamentoAcademiaController@agregarMiembro')
                ->name('divisions.departamentos.academias.agregar-miembro');
Route::resource('divisions.departamentos.academias', 'DivisionDepartamentoAcademiaController');

// -------- USUARIOS ---------
Route::resource('users', 'UsersController');
Route::get('/users/buscar/{consulta}', 'UsersController@buscar')->name('users.buscar');

// ------ REUNIONES -----------
Route::resource('/reuniones', 'ReunionesController',
    ['except' => ['store', 'update', 'destroy']]);
Route::get('/reuniones/{id}/descargarOrdenDelDia', 'ReunionesController@descargarOrdenDelDia')->name('reuniones.ordendeldia.descargar');
