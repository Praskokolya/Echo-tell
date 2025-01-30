<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Mail\EchoMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mime\MessageConverter;

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

Route::controller(QuestionController::class)->group(function () {
    Route::get('questions', 'questions');
    Route::get('create/question', 'createQuestion');
    Route::get('question/{id}/{slug}', 'index');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('home', [HomePageController::class, 'index']);
    Route::get('question/{question_id}/{slug}/response/{response_id}', [ResponseController::class, 'showResponse']);
    Route::get('question/{question_id}/{slug}/responses', [ResponseController::class, 'showQuestionResponses']);
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('user/interactions', [ResponseController::class, 'index']);
    Route::get('profile/{user_name}', [ProfileController::class, 'index']);
    Route::get('message/{uuid}', [MessagesController::class, 'index']);
    Route::get('messages/{uuid}', [MessagesController::class, 'messagesFromUser']);
});
