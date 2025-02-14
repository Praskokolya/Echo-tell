<?php

namespace App\Notifications;

use App\Events\NewResponse;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class NewResponseNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $responseData) {}
  
    private function getUrl(){
        return $this->responseData->question->url . "/response/" . $this->responseData->id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if($notifiable->settings->email_notifications_enabled){
            return ["database", "mail"];
        }
        return ['database'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase()
    {
        return [
            'url' => $this->getUrl(),
            'message' => $this->responseData->user_name . ' replied to your question',
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        if ($notifiable->settings->email_notifications_enabled) {
            return (new MailMessage)->subject('You got a new message!')
                ->line($this->responseData->user_name . ' replied to your question')
                ->action('View Message', $this->getUrl());
        };
    }
}
