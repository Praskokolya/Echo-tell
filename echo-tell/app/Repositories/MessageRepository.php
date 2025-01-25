<?php

namespace App\Repositories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    public function __construct(public Message $message)
    {
        
    }

    public function createMessage($data){
        $this->message->create([
            'user_id' => $data['id'],
            'message' => $data['message'],
            'sender_name' => Auth::user()->name,
            'sender_id' => Auth::user()->id
        ]);
    }
    public function getAll(){
        return Auth::user()->sentMessages()->with('user')->get();
    }
}
