<?php

use App\Http\Controllers\CompanyActionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FinancingController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserActionController;
use App\Http\Controllers\UserController;
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
*/


//register
Route::post('/register', [RegisterController::class, 'registerUser']);
Route::post('/otp', [RegisterController::class, 'otpUser']);
Route::post('/company/register', [RegisterController::class, 'registerCompany']);
Route::post('/company/otp', [RegisterController::class, 'otpCompany']);

//login
Route::post('/login', [LoginController::class, 'loginUser']);
Route::post('/company/login', [LoginController::class, 'loginCompany']);

//lupapassword
Route::post('/reset', [ForgetController::class, 'sendEmailUser']);
Route::post('/resetotp', [ForgetController::class, 'otpUser']);
Route::post('/resetpassword', [ForgetController::class, 'resetUser']);

Route::post('/company/reset', [ForgetController::class, 'sendEmailCompany']);
Route::post('/company/resetotp', [ForgetController::class, 'otpCompany']);
Route::post('/company/resetpassword', [ForgetController::class, 'resetCompany']);

//Guest Routes
Route::get('/', [GuestController::class, 'welcome'])->name('login');
Route::get('/landing', [GuestController::class, 'landing']);
Route::get('/about', [GuestController::class, 'about']);
Route::get('/help', [GuestController::class, 'help']);

Route::middleware(['auth.jwt'])->group(function () {
    //User Routes
    Route::get('/home', [UserController::class, 'home']);
    Route::get('/user/logout', [LogoutController::class, 'user']);
    Route::get('/user/help', [UserController::class, 'help']);

    //profile
    Route::get('/user/profile', [UserController::class, 'profile']);

    Route::post('/user/profile/update', [UserActionController::class, 'profileUpdate']);
    Route::post('/user/avatar/upload', [UserActionController::class, 'updateAvatar']);
    Route::post('/user/avatar/delete', [UserActionController::class, 'deleteAvatar']);
    Route::post('/user/payment', [UserActionController::class, 'paymentMethod']);

    //history
    Route::get('/user/history', [UserController::class, 'history']);
    Route::get('/user/history/selection', [UserController::class, 'historySelection']);
    Route::get('/user/history/accepted', [UserController::class, 'historyAccepted']);
    Route::get('/user/history/rejected', [UserController::class, 'historyRejected']);
    Route::get('/user/history/success', [UserController::class, 'historySuccess']);

    //program action
    Route::post('/user/upload/kontrak', [UserActionController::class, 'uploadContract']);
    Route::post('/user/upload/summary', [UserActionController::class, 'uploadSummary']);

    //program   
    Route::get('/user/program', [UserController::class, 'program']);
    Route::post('/user/participate', [UserActionController::class, 'participate']);

    //Perusahaan Routes

    Route::get('/company', [CompanyController::class, 'index']);
    Route::get('/company/logout', [LogoutController::class, 'company']);

    //program
    Route::get('/company/program', [ProgramController::class, 'company']);
    Route::patch('/company/update/{id}', [ProgramController::class, 'update']);
    Route::post('/company/program/stop', [ProgramController::class, 'stop']);
    Route::post('/company/program/start', [ProgramController::class, 'start']);
    Route::post('/company/program/delete', [ProgramController::class, 'delete']);
    Route::post('/company/program/insert', [ProgramController::class, 'insert']);

    //show participant and editing
    Route::get('/company/participant', [ParticipantController::class, 'index']);
    Route::post('/company/participant/update', [ParticipantController::class, 'update']);

    //show financial particantp and editing
    Route::get('/company/financing', [FinancingController::class, 'index']);
    Route::post('/company/financing/detail', [FinancingController::class, 'detail']);
    Route::post('/company/payment', [FinancingController::class, 'payment']);
    //Route::post('/company/financing/update', 'FinancingController@update');

    //company profile editing
    Route::get('/company/profile', [CompanyController::class, 'profile']);

    Route::post('/company/profile/update', [CompanyActionController::class, 'profileUpdate']);
    Route::post('/company/avatar/upload', [CompanyActionController::class, 'updateAvatar']);
    Route::post('/company/avatar/delete', [CompanyActionController::class, 'deleteAvatar']);
});
