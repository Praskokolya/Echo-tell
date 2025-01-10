<?php

namespace App\Services;

use App\Events\NewResponse;
use App\Models\User;
use App\Notifications\NewResponseNotification;
use App\Repositories\NotificationRepository;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function __construct(public NotificationRepository $notificationRepository) {
    }
    public function createUserNotification($responseData)
    {
        $userForNotification = $this->notificationRepository->getUserForNotification($responseData->question_id);
        $userForNotification->notify(new NewResponseNotification($responseData->user_name));
        $lastResponses = $userForNotification->notifications->sortByDesc('created_at')->take(3);
        broadcast(new NewResponse($lastResponses));
    }
}
