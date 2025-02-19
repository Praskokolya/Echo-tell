<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessagesResource;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * MessagesController constructor.
     *
     * @param MessageRepository $messageRepository
     */
    public function __construct(public MessageRepository $messageRepository) {}

    /**
     * Display the messages page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('messages.message');
    }

    /**
     * Display the user's messages page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function messagesFromUser()
    {
        return view('messages.user-messages');
    }

    /**
     * Retrieve messages from a specific user.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function returnMessagesFromUser($id)
    {
        return $this->messageRepository
            ->getMessagesFromUser($id);
    }

    /**
     * Retrieve all messages.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function returnMessages()
    {
        return MessagesResource::collection(
            $this->messageRepository->getAll()
        );
    }

    /**
     * Retrieve a single message by its ID.
     *
     * @param int $id
     * @return MessagesResource
     */
    public function returnMessage($id)
    {
        return new MessagesResource(
            $this->messageRepository->getMessage($id)
        );
    }

    /**
     * Create a new message.
     *
     * @param Request $request
     * @return void
     */
    public function createMessage(Request $request)
    {
        $this->messageRepository
            ->createMessage($request->all());
    }

    /**
     * Delete a message by its ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteMessage($id)
    {
        $this->messageRepository
            ->delete($id);
    }
}
