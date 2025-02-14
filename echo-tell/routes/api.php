<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponseController;
use App\Http\Middleware\EnsureUserIsAuthor;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('question', [QuestionController::class, 'create'])->name('create.question');
    Route::get('question/responses/{id}', [QuestionController::class, 'returnQuestionResponses']);
    Route::get('user/messages', [MessagesController::class, 'returnMessages']);
    Route::get('user/responses', [ResponseController::class, 'returnResponses']);
    Route::post('response/{id}', [ResponseController::class, 'createResponse']);
    Route::delete('response/{id}', [ResponseController::class, 'deleteResponse']);
    Route::delete('message/{id}', [MessagesController::class, 'deleteMessage'])->middleware([EnsureUserIsAuthor::class . ':message']);

    Route::get('response/{id}', [ResponseController::class, 'returnResponse']);
    Route::get('user/questions', [QuestionController::class, 'returnQuestions']);
    Route::get('notifications', [NotificationController::class, 'returnNotifications']);
    Route::get('user/user-data', [HomePageController::class, 'getHomeData']);
    Route::post('message/{user_name}', [MessagesController::class, 'createMessage']);
    Route::get('user/{user_name}', [ProfileController::class, 'returnUser']);
    Route::get('message/{id}', [MessagesController::class, 'returnMessage'])->middleware([EnsureUserIsAuthor::class . ':message']);
    Route::get('messages/{id}', [MessagesController::class, 'returnMessagesFromUser'])->middleware([EnsureUserIsAuthor::class . ':message']);
});

Route::get('/question/{id}', [QuestionController::class, 'returnData']);
