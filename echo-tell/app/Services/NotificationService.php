<?php

namespace App\Services;

use App\Events\NewResponse;
use App\Models\Message;
use App\Models\ResponseModel;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use App\Notifications\NewResponseNotification;
use App\Repositories\NotificationRepository;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function __construct(public NotificationRepository $notificationRepository) {
    }
    public function createUserNotification($data)
    {
        $userForNotification = $this->notificationRepository->getUserForNotification($data->question_id ?: $data->user_id);
        switch(get_class($data)){
            case ResponseModel::class: 
                $userForNotification->notify(new NewResponseNotification($data));
                break;
            case Message::class:
                $userForNotification->notify(new NewMessageNotification($data));
                break;
        };

        $lastNotifications = $userForNotification->notifications->sortByDesc('created_at')->take(3)->pluck('data');
        broadcast(new NewResponse($lastNotifications));
    }
}
