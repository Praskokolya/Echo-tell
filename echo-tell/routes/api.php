<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetController;
use App\Http\Controllers\HomePageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route::post('create', [HomePageController::class, 'createMessage'])->name('create.message');
});
Route::post('create', [HomePageController::class, 'createMessage'])->name('create.message');

Route::controller(AuthController::class)->group(function () {
    Route::get('auth/registration', 'registation')->name('registration');
    Route::post('auth/login',[AuthController::class, 'login'])->name('login');
});


