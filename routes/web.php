<?php

use Illuminate\Support\Facades\Route;

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

//Rotas para realizar a autenticação.
Route::group(['middleware' => 'guest'], function() {

    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

});

//Rotas para usuários autenticados.
Route::group(['middleware' => 'auth'], function() {

    Route::get('/',  [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    //Middleware responsável por checar se usuário possui acesso a funcionalidade.
    Route::group(['middleware' => 'checkPermission'], function() {

        Route::group([], function() {

            Route::get('livros',                ['uses' => 'App\Http\Controllers\BookController@index',  'permission' => 'books.index']);
            Route::get('livros/criar',          ['uses' => 'App\Http\Controllers\BookController@create', 'permission' => 'books.insert']);
            Route::get('livros/{id}/editar',    ['uses' => 'App\Http\Controllers\BookController@edit',   'permission' => 'books.update'])->where(['id' => '[0-9+]']);
            Route::post('livros',               ['uses' => 'App\Http\Controllers\BookController@insert', 'permission' => 'books.insert']);
            Route::put('livros',                ['uses' => 'App\Http\Controllers\BookController@update', 'permission' => 'books.update']);
            Route::delete('livros',             ['uses' => 'App\Http\Controllers\BookController@delete', 'permission' => 'books.delete']);

        });

    });

});
