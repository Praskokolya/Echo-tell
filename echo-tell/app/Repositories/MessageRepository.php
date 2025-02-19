<?php

namespace App\Repositories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    /**
     * Number of messages per page for the user
     */
    const USER_MESSAGES_PER_PAGE = 6;

    /**
     * Number of messages per page for all users
     */
    const MESSAGES_PER_PAGE = 10;

    /**
     * Constructor to initialize Message and User models.
     *
     * @param \App\Models\Message $message
     * @param \App\Models\User $user
     */
    public function __construct(public Message $message, public User $user) {}

    /**
     * Creates a new message.
     *
     * @param array $data Message data
     * @return void
     */
    public function createMessage(array $data)
    {
        $this->message->create([
            'user_id' => $data['id'],
            'message' => $data['message'],
            'sender_name' => Auth::user()->name,
            'sender_id' => Auth::user()->id,
            'name_visibility' => $data['name_visibility']
        ]);
    }

    /**
     * Retrieves a message by its ID.
     *
     * @param int $id Message ID
     * @return \App\Models\Message|null
     */
    public function getMessage(int $id)
    {
        return $this->message->find($id);
    }

    /**
     * Retrieves all messages sent by the current user.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->getSentMessages(Auth::user())->paginate(self::MESSAGES_PER_PAGE);
    }

    /**
     * Retrieves messages sent from a specific user.
     *
     * @param int $id User ID
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getMessagesFromUser(int $id)
    {
        $message = $this->message->find($id);

        return $this->getSentMessagesFromUser($message)->latest()->paginate(self::USER_MESSAGES_PER_PAGE);
    }

    /**
     * Deletes a message by its ID.
     *
     * @param int $id Message ID
     * @return void
     */
    public function delete(int $id)
    {
        $this->message->destroy($id);
    }

    /**
     * Retrieves sent messages for a user.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    private function getSentMessages(User $user)
    {
        return $user->sentMessages()->with('user');
    }

    /**
     * Retrieves messages sent from a specific user.
     *
     * @param \App\Models\Message $message
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    private function getSentMessagesFromUser(Message $message)
    {
        return $this->user
            ->find($message->sender_id)
            ->sentMessages()
            ->where('user_id', $message->user_id)
            ->where('name_visibility', $message->name_visibility);
    }
}
