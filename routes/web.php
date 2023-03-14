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

    //rute web
    Route::get('/', 'LandingController@welcome');

    //rute landing
    Route::get('/landing', 'LandingController@index');

    //rute about
    Route::get('/about', 'AboutController@index');

    //rute help
    Route::get('/help', 'HelpController@index');

    //rute register
    Route::post('/register', 'RegisterController@register');
    Route::post('/register/otp', 'RegisterController@otp');

    //rute login
    Route::post('/login', 'LoginController@login');

    //rute register Company
    Route::post('/company/register', 'RegistercompanyController@register');

    //rute login Company
    Route::post('/company/login', 'LogincompanyController@login');

    //rute lupa password
    Route::post('/forgotpassword', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/otp', 'ForgotPasswordController@otp');
    Route::post('/resetpassword', 'ForgotPasswordController@reset');

    Route::group(['middleware' => ['auth']], function () {
        //rute logout
        Route::get('/logout', 'LogoutController@perform');

        //rute home
        Route::get('/home', 'HomeController@index');

        //help
        Route::get('/user/help', 'HelpController@user');

        //profile
        Route::get('/profile', 'ProfileController@index');
        Route::post('/profile/update', 'ProfileController@update');
        Route::post('/profile/avatar/upload', 'ProfileController@updateAvatar');
        Route::post('/profile/avatar/delete', 'ProfileController@deleteAvatar');

        //history
        Route::get('/history', 'HistoryController@index');
        Route::get('/history/selection', 'HistoryController@selection');
        Route::get('/history/accepted', 'HistoryController@accepted');
        Route::get('/history/rejected', 'HistoryController@rejected');
        Route::get('/history/success', 'HistoryController@success');

        //program
        Route::get('/program', 'ProgramController@index');
        Route::post('/program/participate', 'ProgramController@participate');
    });
    Route::group(['middleware' => ['auth:company']], function () {
        //home
        Route::get('/company', 'CompanyController@index');
        Route::get('/company/logout', 'LogoutController@company');

        //show program and editing
        Route::get('/company/program', 'ProgramCompanyController@index')->name('company.program');
        Route::post('/company/program/status', 'ProgramCompanyController@updateStatus')->name('companyprogram.status');
        Route::post('/company/program/delete', 'ProgramCompanyController@delete')->name('companyprogram.delete');
        Route::post('/company/program/insert', 'ProgramCompanyController@insert')->name('companyprogram.participate');

        //show participant and editing
        Route::get('/company/participant', 'ParticipantController@index')->name('company.participant');
        Route::post('/company/participant/update', 'ParticipantController@update')->name('companyparticipant.update');

        //show financial particantp and editing
        Route::get('/company/financing', 'FinancingController@index');
        Route::post('/company/financing/detail', 'FinancingController@detail');
        Route::post('/company/payment', 'FinancingController@payment');
        //Route::post('/company/financing/update', 'FinancingController@update')->name('companyfinancing.update');

        //company profile editing
        Route::get('/company/profile', 'CompanyProfileController@index')->name('company.profile');
        Route::post('/company/profile/update', 'CompanyProfileController@update')->name('companyprofile.update');
    });
});
