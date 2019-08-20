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

Route::resource('divisions', 'DivisionController');
Route::get('/divisions/buscar/{busqueda}', 'DivisionController@buscar')->name('divisions.buscar');

Route::resource('departamentos', 'DepartamentosController');


Route::post('/users', 'UsersController@store')->name('users.store');

Route::get('/academicos', 'AcademicosController@index')
            ->name('academicos.index')
            ->middleware('auth.admin');
Route::post('/academicos', 'AcademicosController@store')->name('academicos.store');
Route::get('/academicos/create', 'AcademicosController@create')
            ->name('academicos.create')
            ->middleware('auth.admin');
Route::get('/academicos/registrar', 'AcademicosController@registrar')
            ->name('academicos.registrar')
            ->middleware('auth.admin');
Route::get('/academicos/buscar/{busqueda}', 'AcademicosController@buscar')->name('academicos.buscar');
Route::get('/academicos/{academico}', 'AcademicosController@show')->name('academicos.show');
Route::delete('/academicos/{academico}', 'AcademicosController@destroy')->name('academicos.destroy');
Route::get('/academicos/{academico}/edit', 'AcademicosController@edit')->name('academicos.edit');
Route::patch('/academicos/{academico}', 'AcademicosController@update')->name('academicos.update');
