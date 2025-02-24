<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SettingsController;
use App\Http\Middleware\EnsureUserIsAuthor;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {

    // User Data
    Route::get('user/user-data', [HomePageController::class, 'getData']);
    Route::get('user/{user_name}', [ProfileController::class, 'returnUser']);

    // Questions
    Route::get('user/questions', [QuestionController::class, 'returnQuestions']);
    Route::get('question/responses/{id}', [QuestionController::class, 'returnQuestionResponses']);
    Route::get('question/{id}', [QuestionController::class, 'returnData']);
    Route::post('question', [QuestionController::class, 'create'])->name('create.question');
    Route::delete('question/{id}', [QuestionController::class, 'deleteQuestion'])->middleware([EnsureUserIsAuthor::class . ':question']);

    // Responses
    Route::get('user/responses', [ResponseController::class, 'returnResponses']);
    Route::get('response/{id}', [ResponseController::class, 'returnResponse'])->middleware([EnsureUserIsAuthor::class . ':response']);
    Route::post('response/{id}', [ResponseController::class, 'createResponse']);
    Route::delete('response/{id}', [ResponseController::class, 'deleteResponse'])->middleware([EnsureUserIsAuthor::class . ':response']);

    // Messages
    Route::get('user/messages', [MessagesController::class, 'returnMessages']);
    Route::get('message/{id}', [MessagesController::class, 'returnMessage'])->middleware([EnsureUserIsAuthor::class . ':message']);
    Route::get('messages/{id}', [MessagesController::class, 'returnMessagesFromUser'])->middleware([EnsureUserIsAuthor::class . ':message']);
    Route::post('message/{user_name}', [MessagesController::class, 'createMessage']);
    Route::delete('message/{id}', [MessagesController::class, 'deleteMessage'])->middleware([EnsureUserIsAuthor::class . ':message']);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'returnNotifications']);

    // Settings
    Route::post('send-daily-statistics', [SettingsController::class, 'sendDailyStatistics']);
    Route::patch('settings/mail-notifications', [SettingsController::class, 'changeMailNotifications']);
    Route::patch('settings/daily-mails', [SettingsController::class, 'changeDailyMails']);
});
