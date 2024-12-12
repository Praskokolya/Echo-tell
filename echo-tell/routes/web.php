<?php

use App\Http\Controllers\AuthController;
use App\Mail\EchoMail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    Mail::to('nikolay.prasko@gmail.com')->send(new EchoMail());
});
// Auth routes
Route::controller(AuthController::class)->group(function(){
    Route::get('auth','index');
    Route::get('auth/registration','registation');
    Route::post('auth/registration/create','create');
});
