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
    Route::get('user', [HomePageController::class, 'user']);
    Route::get('profile/{user_name}', [ProfileController::class, 'show']);

    // Questions
    Route::get('user/questions', [QuestionController::class, 'returnQuestions']);
    Route::get('question/responses/{id}', [QuestionController::class, 'returnResponses']);
    Route::get('question/{id}', [QuestionController::class, 'show']);
    Route::post('question', [QuestionController::class, 'store'])->name('create.question');
    Route::delete('question/{id}', [QuestionController::class, 'destroy'])->middleware([EnsureUserIsAuthor::class . ':question']);

    // Responses
    Route::get('user/responses', [ResponseController::class, 'responses']);
    Route::get('response/{id}', [ResponseController::class, 'show'])->middleware([EnsureUserIsAuthor::class . ':response']);
    Route::post('response/{id}', [ResponseController::class, 'store']);
    Route::delete('response/{id}', [ResponseController::class, 'destroy'])->middleware([EnsureUserIsAuthor::class . ':response']);

    // Messages
    Route::get('user/messages', [MessagesController::class, 'messages']);
    Route::get('message/{id}', [MessagesController::class, 'show'])->middleware([EnsureUserIsAuthor::class . ':message']);
    Route::get('messages/{id}', [MessagesController::class, 'userMessages'])->middleware([EnsureUserIsAuthor::class . ':message']);
    Route::post('message/{user_name}', [MessagesController::class, 'store']);
    Route::delete('message/{id}', [MessagesController::class, 'destroy'])->middleware([EnsureUserIsAuthor::class . ':message']);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'notifications']);

    // Settings
    Route::post('send-daily-statistics', [SettingsController::class, 'sendDailyStatistics']);
    Route::patch('settings/mail-notifications', [SettingsController::class, 'changeMailNotifications']);
    Route::patch('settings/daily-mails', [SettingsController::class, 'changeDailyMails']);
});
