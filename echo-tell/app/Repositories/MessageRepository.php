<?php

namespace App\Repositories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    const USER_MESSAGES_PER_PAGE = 6;

    const MESSAGES_PER_PAGE = 10;

    public function __construct(public Message $message, public User $user) {}

    public function create(array $data)
    {
        $this->message->create([
            'user_id' => $data['id'],
            'message' => $data['message'],
            'sender_name' => Auth::user()->name,
            'sender_id' => Auth::user()->id,
            'name_visibility' => $data['name_visibility']
        ]);
    }

    public function get(string $id): Message
    {
        return $this->message->find($id);
    }

    public function getAll(): LengthAwarePaginator
    {
        return Auth::user()->sentMessages()->with('user')->paginate(self::MESSAGES_PER_PAGE);
    }

    public function getMessagesFromUser(string $id): LengthAwarePaginator
    {
        $message = $this->message->find($id);
        
        return $this->user
            ->find($message->sender_id)
            ->sentMessages()
            ->where('user_id', $message->user_id)
            ->where('name_visibility', $message->name_visibility)
            ->with('user')
            ->latest()
            ->paginate(self::USER_MESSAGES_PER_PAGE);
    }

    public function delete(string $id)
    {
        $this->message->destroy($id);
    }
}
