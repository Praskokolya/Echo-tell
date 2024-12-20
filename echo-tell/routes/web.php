<?php

use App\Http\Controllers\AuthController;
use App\Mail\EchoMail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Auth routes
Route::controller(AuthController::class)->group(function(){
    Route::get('auth','index');
    Route::get('auth/registration','registation')->name('registration');
    Route::post('auth/registration/store','store');
    Route::get('auth/registration/confirm',function(){
        return view('verify-form');
    })->name('verify.form');
    Route::post('auth/registration/confirm/code', 'passVerificationCode')->name('pass.code');
    Route::post('auth/login','login')->name('login');
});
