<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('create', [HomePageController::class, 'createQuestion'])->name('create.message');
});

 


