<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponseController;
use Laravel\Reverb\Pulse\Livewire\Messages;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/question', [QuestionController::class, 'create'])->name('create.question');
    Route::get('/question/responses/{id}', [QuestionController::class, 'returnQuestionResponses']);
    Route::get('/user/interactions', [ResponseController::class, 'returnInteractions']);
    Route::post('/response/{id}', [ResponseController::class, 'createResponse']);
    Route::delete('/response/{id}', [ResponseController::class, 'deleteResponse']);
    Route::get('user/questions', [QuestionController::class, 'returnQuestions']);
    Route::get('notifications', [NotificationController::class, 'returnNotifications']);
    Route::get('/response/{id}', [ResponseController::class, 'returnResponse']);
    Route::get('/responses/{id}');
    Route::get('/user/home-data', [HomePageController::class, 'getHomeData']);
    Route::post('message/{user_name}', [MessagesController::class, 'createMessage']);
    Route::get('/user/{user_name}', [ProfileController::class, 'returnUser']);
});

Route::get('/question/{id}', [QuestionController::class, 'returnData']);
