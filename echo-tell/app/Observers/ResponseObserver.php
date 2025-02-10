<?php

namespace App\Observers;

use App\Models\Response;
use App\Models\User;
use App\Notifications\NewResponseNotification;
use App\Repositories\UserRepository;
use App\Services\NotificationService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResponseObserver
{
    public function __construct(public NotificationService $notificationService)
    {
        
    }
    
    public function created(Response $Response){
        $this->notificationService->createUserNotification($Response);
    } 
}
