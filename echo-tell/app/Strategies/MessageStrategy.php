<?php

namespace App\Strategies;

use App\Interfaces\VerificationInterface;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageStrategy implements VerificationInterface
{

    public function verify(mixed $id): int
    {
        $message = Message::find($id);

        if (Auth::user()->id == $message->user_id || Auth::id() == $message->sender_id) {
            return 1;
        }
        return 0;
    }
}
