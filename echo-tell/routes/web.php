<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\QuestionContoller;
use App\Http\Controllers\ResponseController;
use App\Mail\EchoMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Auth routes
// Auth::routes();
Route::controller(AuthController::class)->group(function () {
    Route::get('auth', 'index');
    Route::get('auth/registration', 'registation')->name('registration');
    Route::post('auth/login', [AuthController::class, 'login'])->name('login');
    Route::post('auth/registration/store', 'store');
    Route::get('auth/registration/confirm', function () {
        return view('verify-form');
    })->name('verify.form');
    Route::post('auth/registration/confirm/code', 'passVerificationCode')->name('pass.code');
});
Route::get('home', [HomePageController::class, 'index'])->name('home');
Route::prefix('question')->group(function(){
    Route::get('/{id}/{slug}', [QuestionContoller::class, 'show']);
});
Route::get('user/responses', [ResponseController::class, 'index']);
