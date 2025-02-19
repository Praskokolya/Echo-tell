<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param object $messageData
     */
    public function __construct(public $messageData) {}

    /**
     * Get the notification's delivery channels.
     *
     * @param object $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // If email notifications are enabled in the user's settings, send via database and mail
        if ($notifiable->settings->email_notifications_enabled) {
            return ['database', 'mail'];
        }
        
        return ['database'];
    }

    /**
     * Get the database notification representation.
     *
     * @return array
     */
    public function toDatabase(): array
    {
        return [
            'url' => $this->messageData->url,
            'message' => $this->messageData->sender_name . ' sent you a message',
        ];
    }

    /**
     * Get the mail notification representation.
     *
     * @param object $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage|null
     */
    public function toMail(object $notifiable)
    {
        // Send the email notification only if email notifications are enabled
        if ($notifiable->settings->email_notifications_enabled) {
            return (new MailMessage)
                ->subject('You got a new message!')
                ->line('You have received a new message from ' . $this->messageData->sender_name)
                ->action('View Message', $this->messageData->url);
        }

        return null;
    }
}
