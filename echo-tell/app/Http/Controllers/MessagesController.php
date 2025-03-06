<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessagesResource;
use App\Repositories\MessageRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MessagesController extends Controller
{
    public function __construct(public MessageRepository $messageRepository) {}

    public function index(): View
    {
        return view('messages.message');
    }

    public function messagesFromUser(): View
    {
        return view('messages.user-messages');
    }

    public function userMessages(string $id): LengthAwarePaginator
    {
        return $this->messageRepository
            ->getMessagesFromUser($id);
    }

    public function messages(): AnonymousResourceCollection
    {
        return MessagesResource::collection(
            $this->messageRepository->getAll()
        );
    }

    public function show(string $id): MessagesResource
    {
        return new MessagesResource(
            $this->messageRepository->get($id)
        );
    }

    public function store(Request $request)
    {
        $this->messageRepository
            ->create($request->all());
    }

    public function destroy(string $id)
    {
        $this->messageRepository
            ->delete($id);
    }
}
