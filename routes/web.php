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

Route::get('/', function() {
    return view('index');
});

Route::namespace('App\Http\Controllers')->group(function() {
    #Auth functions
    Route::namespace('Auth')->group(function() {
        Route::get('login','LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('doLogin');
        Route::post('logout', 'LoginController@logout')->name('logout');

        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register')->name('doRegister');
    });

    #Authed
    Route::middleware('auth')->group(function() {
        Route::get('home','HomeController@index')->name('home');

        Route::namespace('Frontend')->group(function() {
            Route::group(['prefix' => 'posts', 'as' => 'post.'], function() {
                Route::get('/','PostController@index')->name('index');
                Route::get('{id}','PostController@show')->name('show');
                Route::get('{id}/edit','PostController@edit')->name('edit');
                Route::put('{id}/edit','PostController@update')->name('update');
                Route::get('create','PostController@create')->name('create');
                Route::post('create','PostController@store')->name('store');
            });
        });

        Route::namespace('Backend')->group(function() {
            Route::group(['prefix' => 'logs', 'as' => 'log.'], function() {
                Route::get('/','LogController@index')->name('index');
            });
        });
    });
});
 


