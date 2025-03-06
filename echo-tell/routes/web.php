<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Http\Middleware\EnsureUserIsAuthor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('auth/login', 'index');
    Route::get('auth/registration', 'registation')->name('registration');
    Route::post('auth/login', [AuthController::class, 'login'])->name('login');
    Route::post('auth/registration/store', 'store');
    Route::get('auth/registration/confirm', function () {
        return view('verify-form');
    })->name('verify.form');
    Route::post('auth/registration/confirm/code', 'passVerificationCode')->name('pass.code');
});

Route::controller(QuestionController::class)->group(function () {
    Route::get('questions', 'questions');
    Route::get('question/create', 'create');
    Route::get('question/{id}/{slug}', 'index')->middleware([EnsureUserIsAuthor::class . ':question']);
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('home', [HomePageController::class, 'index']);
    Route::get('question/{question_id}/{slug}/response/{id}', [ResponseController::class, 'showResponse'])->middleware([EnsureUserIsAuthor::class . ':response']);
    Route::get('question/{question_id}/{slug}/responses', [ResponseController::class, 'showQuestionResponses']);
    
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('user/interactions', [ResponseController::class, 'index']);

    Route::get('profile/{user_name}', [ProfileController::class, 'index']);
    Route::get('message/{id}', [MessagesController::class, 'index'])->middleware([EnsureUserIsAuthor::class. ':message'])->name('sho');
    Route::get('messages/{id}', [MessagesController::class, 'messagesFromUser']);
    Route::post('logout', function(){
        Auth::logout();
    });
});
