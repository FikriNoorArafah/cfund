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

    //rute doc
    Route::get('/docs', 'DocController@index')->name('doc');

    //rute home
    Route::get('/', 'HomeController@index')->name('user.index');

    //rute help
    Route::get('/help', 'HelpController@index')->name('user.help');

    //get csrf
    Route::get('/get-csrf-token', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    });



    Route::group(['middleware' => ['guest']], function () {
        //rute register
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        //rute login
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

        //rute register Company
        Route::get('/company/register', 'RegistercompanyController@show')->name('registercompany.show');
        Route::post('/company/register', 'RegistercompanyController@register')->name('registercompany.perform');

        //rute login Company
        Route::get('/company/login', 'LogincompanyController@show')->name('logincompany.show');
        Route::post('/company/login', 'LogincompanyController@login')->name('logincompany.perform');

        //rute lupa password dan kirim email
        Route::get('/forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/forgot-password', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //rute setelah dari email
        Route::get('/reset-password/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/reset-password', 'ResetPasswordController@reset')->name('password.update');
    });

    Route::group(['middleware' => ['auth']], function () {
        //rute logout
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        //profile 
        Route::get('/profile', 'ProfileController@index')->name('user.profile');
        Route::post('/profile/update', 'ProfileController@update')->name('user.profile.update');

        //history
        Route::get('/history', 'HistoryController@index')->name('user.history');
        Route::get('/history/selection', 'HistoryController@selection')->name('user.history.selection');
        Route::get('/history/accepted', 'HistoryController@accepted')->name('user.history.accepted');
        Route::get('/history/rejected', 'HistoryController@rejected')->name('user.history.rejected');
        Route::get('/history/success', 'HistoryController@success')->name('user.history.success');
        //program
        Route::get('/program', 'ProgramController@index')->name('user.program');
    });
    Route::group(['middleware' => ['auth:company']], function () {
        //home
        Route::get('/company', 'CompanyController@index')->name('company.index');
        Route::get('/company/logout', 'LogoutcompanyController@perform')->name('logoutcompany.perform');
    });
});
