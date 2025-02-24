<?php

namespace App\Services;

use App\Events\NewInteraction;
use App\Models\Message;
use App\Models\Response;
use App\Notifications\NewMessageNotification;
use App\Notifications\NewResponseNotification;
use App\Repositories\NotificationRepository;


class NotificationService
{
    public function __construct(public NotificationRepository $notificationRepository) {}
    public function createUserNotification($data)
    {
        $userForNotification = $this->notificationRepository->getUserForNotification($data->author_id ?: $data->user_id);

        switch (get_class($data)) {
            case Response::class:
                $userForNotification->notify(new NewResponseNotification($data));
                break;
            case Message::class:
                $userForNotification->notify(new NewMessageNotification($data));
                break;
        };
        
        $lastNotifications = $userForNotification->notifications
            ->sortByDesc('created_at')
            ->take(3)
            ->map(function ($notification) {
                return [
                    'notifiable_id' => $notification->notifiable_id,
                    'data' => $notification->data,
                ];
            });

        broadcast(new NewInteraction($lastNotifications, $userForNotification->id));
    }
}
