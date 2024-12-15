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
    Route::get('auth/registration','registation');
    Route::post('auth/registration/store','store');
    Route::get('auth/registration/confirm',function(){
        return view('verify-form');
    })->name('verify.form');
});
