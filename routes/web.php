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

        Route::get("usuario-biblioteca/emprestimos", ['uses' => 'App\Http\Controllers\LendingBookController@indexBookForUsers', 'permission' => 'loans.list']);

        //Rotas para gerenciamento de livros.
        Route::group([], function() {

            Route::get('livros',                ['uses' => 'App\Http\Controllers\BookController@index',  'permission' => 'books.index']);
            Route::get('livros/criar',          ['uses' => 'App\Http\Controllers\BookController@create', 'permission' => 'books.insert']);
            Route::get('livros/{id}/editar',    ['uses' => 'App\Http\Controllers\BookController@edit',   'permission' => 'books.update'])->where(['id' => '[0-9+]']);
            Route::post('livros',               ['uses' => 'App\Http\Controllers\BookController@insert', 'permission' => 'books.insert']);
            Route::put('livros',                ['uses' => 'App\Http\Controllers\BookController@update', 'permission' => 'books.update']);
            Route::delete('livros',             ['uses' => 'App\Http\Controllers\BookController@delete', 'permission' => 'books.delete']);

        });

        //Rotas para gerenciamento de usuários.
        Route::group([], function() {

            Route::get('usuarios',                ['uses' => 'App\Http\Controllers\UserController@index',  'permission' => 'users.index']);
            Route::get('usuarios/criar',          ['uses' => 'App\Http\Controllers\UserController@create', 'permission' => 'users.insert']);
            Route::get('usuarios/{id}/editar',    ['uses' => 'App\Http\Controllers\UserController@edit',   'permission' => 'users.update'])->where(['id' => '[0-9+]']);
            Route::post('usuarios',               ['uses' => 'App\Http\Controllers\UserController@insert', 'permission' => 'users.insert']);
            Route::put('usuarios',                ['uses' => 'App\Http\Controllers\UserController@update', 'permission' => 'users.update']);
            Route::delete('usuarios',             ['uses' => 'App\Http\Controllers\UserController@delete', 'permission' => 'users.delete']);

        });

        //Rotas para gerenciamento de usuários.
        Route::group([], function() {

            Route::get('emprestimos',                ['uses' => 'App\Http\Controllers\LendingBookController@index',         'permission' => 'lending-books.index']);
            Route::get('emprestimos/criar',          ['uses' => 'App\Http\Controllers\LendingBookController@create',        'permission' => 'lending-books.insert']);
            Route::post('emprestimos',               ['uses' => 'App\Http\Controllers\LendingBookController@insert',        'permission' => 'lending-books.insert']);
            Route::delete('emprestimos',             ['uses' => 'App\Http\Controllers\LendingBookController@delete',        'permission' => 'lending-books.delete']);
            Route::post('emprestimos/atrasado',      ['uses' => 'App\Http\Controllers\LendingBookController@delayed',       'permission' => 'lending-books.delayed']);
            Route::post('emprestimos/devolver',      ['uses' => 'App\Http\Controllers\LendingBookController@returnBook',    'permission' => 'lending-books.return']);
            Route::get('emprestimos/usuarios/obter', ['uses' => 'App\Http\Controllers\LendingBookController@getUsers',      'permission' => 'lending-books.index']);
            Route::get('emprestimos/livros/obter',   ['uses' => 'App\Http\Controllers\LendingBookController@getBooks',      'permission' => 'lending-books.index']);
            Route::get('emprestimos/{id}/info',      ['uses' => 'App\Http\Controllers\LendingBookController@info',          'permission' => 'lending-books.index'])->where('id', '[0-9]+');

        });

    });

});
