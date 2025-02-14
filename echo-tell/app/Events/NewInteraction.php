<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewInteraction implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $notification, public $userId)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel("notification.{$this->userId}");
    }

    public function broadcastWith()
    {
        return [
            'response' => $this->notification,
        ];
    }
}
