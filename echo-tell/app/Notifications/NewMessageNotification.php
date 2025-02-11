<?php

namespace App\Notifications;

use App\Mail\SendCodeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewMessageNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $messageData) {}
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if($notifiable->settings->email_notifications_enabled){
            return ['database', 'mail'];
        }
        return ['database'];
    }

    public function toDatabase(): array
    {
        return [
            'url' => $this->messageData->url,
            'message' => $this->messageData->sender_name . ' sent you a message'
        ];
    }

    public function toMail(object $notifiable)
    {
        if ($notifiable->settings->email_notifications_enabled) {
            return (new MailMessage)
                ->subject('You got a new message!')
                ->line('You have received a new message from ' . $this->messageData->sender_name)
                ->action('View Message', $this->messageData->url);
        } else {
            return null;
        }
    }
}
