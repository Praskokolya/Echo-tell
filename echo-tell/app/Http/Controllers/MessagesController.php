<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessagesResource;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function __construct(public MessageRepository $messageRepository) {}

    public function index()
    {
        return view('messages.message');
    }

    public function messagesFromUser(){
        return view('messages.user-messages');
    }

    public function returnMessagesFromUser($id){
        return $this->messageRepository->getMessagesFromUser($id);
    }
    public function returnMessages(){
        return MessagesResource::collection($this->messageRepository->getAll());
 
    }
    public function returnMessage($id){
        return new MessagesResource($this->messageRepository->getMessage($id));
    }
    public function createMessage(Request $request)
    {
        $this->messageRepository->createMessage($request->all());
    }
    public function deleteMessage($id){
        $this->messageRepository->delete($id);
    }
    
}
