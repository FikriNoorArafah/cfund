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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });

    Route::group(['middleware' => ['auth']], function() {
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});
