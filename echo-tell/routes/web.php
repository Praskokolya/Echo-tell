<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::controller(AuthController::class)->group(function(){
    Route::get('auth','index');
    Route::get('auth/registration','registation');
    Route::post('auth/registration/create','create');
});
