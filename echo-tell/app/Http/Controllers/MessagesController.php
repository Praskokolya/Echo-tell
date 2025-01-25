<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function __construct(public MessageRepository $messageRepository) {}
    public function index()
    {
        return view('user-profile');
    }
    public function createMessage(Request $request)
    {
        $this->messageRepository->createMessage($request->all());
    }
}
