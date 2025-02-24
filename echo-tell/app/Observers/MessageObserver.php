<?php

namespace App\Observers;

use App\Models\Message;
use App\Services\NotificationService;
class MessageObserver
{
    public function __construct(public NotificationService $notificationService) {}

    public function created(Message $message)
    {
        $this->notificationService
            ->createUserNotification($message);
    }
}
