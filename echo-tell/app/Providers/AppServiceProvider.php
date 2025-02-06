<?php

namespace App\Providers;

use App\Interfaces\VerificationInterface;
use App\Models\Message;
use App\Models\ResponseModel;
use App\Models\User;
use App\Observers\MessageObserver;
use App\Observers\NotificationObserver;
use App\Observers\ResponseObserver;
use App\Services\VerificationService;
use GuzzleHttp\Psr7\Response;
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
        Message::observe(MessageObserver::class);
        ResponseModel::observe(ResponseObserver::class);
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
