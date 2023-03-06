<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    //rute home
    Route::get('/', 'HomeController@index')->name('user.index');

    Route::group(['middleware' => ['guest']], function () {
        //rute register
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        //rute login
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });

    Route::group(['middleware' => ['auth']], function () {
        //rute logout
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});
