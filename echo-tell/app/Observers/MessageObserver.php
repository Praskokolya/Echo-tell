<?php

namespace App\Observers;

use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageObserver
{
    public function __construct(public NotificationService $notificationService )
    {
        
    }
    
    public function created(Message $message){
        $this->notificationService->createUserNotification($message);
    }
}
