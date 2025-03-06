<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Question;
use App\Models\Response;
use App\Models\User;
use App\Observers\MessageObserver;
use App\Observers\QuestionObserver;
use App\Observers\ResponseObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Question::observe(QuestionObserver::class);
        User::observe(UserObserver::class);
        Message::observe(MessageObserver::class);
        Response::observe(ResponseObserver::class);
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
