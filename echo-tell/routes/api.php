<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/question', [QuestionController::class, 'create'])->name('create.question');
    Route::get('/user/responses', [ResponseController::class, 'returnResponses']);
    Route::post('/response/{id}', [ResponseController::class, 'createResponse']);
    Route::delete('user/responses/{id}', [ResponseController::class, 'deleteResponse']);
    Route::get('user/questions', [QuestionController::class, 'returnQuestions']);
    // Треба додати сторінку усіх питань з можливістю натискання на питання і переходу на сторінку питання + відповіді + додати мідлвейр на перевірку 
    // чи користувач є автором питання + додати можливість видалення питання + реагування + якщо ти автор то прибрати 
    // можливість відповідати на питання (за допомогою мідлвейру) 
});

Route::get('/question/{id}', [QuestionController::class, 'returnData']);
