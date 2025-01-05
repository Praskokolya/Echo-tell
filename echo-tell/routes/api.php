<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\QuestionContoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/question', [QuestionContoller::class, 'create'])->name('create.question');
    Route::get('/user/responses', [ResponseController::class, 'returnResponses'])->middleware('auth:sanctum');
    Route::post('/response/{id}', [ResponseController::class, 'createResponse'])->middleware('auth:sanctum');
    Route::delete('user/responses/{id}', [ResponseController::class, 'deleteResponse'])->middleware('auth:sanctum');
});
Route::get('/question/{id}', [QuestionContoller::class, 'returnData']);

