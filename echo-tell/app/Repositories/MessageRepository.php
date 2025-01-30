<?php

namespace App\Repositories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    public function __construct(public Message $message, public User $user) {}

    public function createMessage($data)
    {
        $this->message->create([
            'user_id' => $data['id'],
            'message' => $data['message'],
            'sender_name' => Auth::user()->name,
            'sender_id' => Auth::user()->id,
            'name_visibility' => $data['name_visibility']
        ]);
    }

    public function getMessage($id)
    {
        return $this->message->find($id);
    }

    public function getAll()
    {
        return Auth::user()->sentMessages()->with('user')->get();
    }

    public function getMessagesFromUser($id)
    {
        $message = $this->message->find($id);
        
        return $this->user
            ->find($message->sender_id)
            ->sentMessages()
            ->where('user_id', $message->user_id)
            ->paginate(6);
    }
}
