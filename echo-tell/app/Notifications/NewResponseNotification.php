<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewResponseNotification extends Notification
{
    use Queueable;

    public function __construct(public $responseData) {}

    private function getUrl()
    {
        return $this->responseData->question->url . "/response/" . $this->responseData->id;
    }

    public function via(object $notifiable): array
    {
        // If email notifications are enabled, send via database and mail
        if ($notifiable->settings->email_notifications_enabled) {
            return ["database", "mail"];
        }

        return ['database'];
    }

    public function toDatabase()
    {
        return [
            'url' => $this->getUrl(),
            'message' => $this->responseData->user_name . ' replied to your question',
        ];
    }

    public function toMail($notifiable): ?MailMessage
    {
        // Send the email notification only if email notifications are enabled
        if ($notifiable->settings->email_notifications_enabled) {
            return (new MailMessage)
                ->subject('You got a new response!')
                ->line($this->responseData->user_name . ' replied to your question')
                ->action('View Response', $this->getUrl());
        }

        return null;
    }
}
