<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewResponseNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param object $responseData
     */
    public function __construct(public $responseData) {}

    /**
     * Get the URL of the response.
     *
     * @return string
     */
    private function getUrl()
    {
        return $this->responseData->question->url . "/response/" . $this->responseData->id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param object $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // If email notifications are enabled, send via database and mail
        if ($notifiable->settings->email_notifications_enabled) {
            return ["database", "mail"];
        }

        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array
     */
    public function toDatabase()
    {
        return [
            'url' => $this->getUrl(),
            'message' => $this->responseData->user_name . ' replied to your question',
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param object $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage|null
     */
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
