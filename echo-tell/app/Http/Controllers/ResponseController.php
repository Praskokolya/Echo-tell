<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessagesResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\ResponseResource;
use App\Models\Message;
use App\Repositories\MessageRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResponseController extends Controller
{
    public function __construct(
        public ResponseRepository $responseRepository,
        public MessageRepository $messageRepository
    ) {}
    public function index()
    {
        return view('responses.responses');
    }

    public function showResponse()
    {
        return view('responses.response');
    }

    public function showQuestionResponses()
    {
        return view('responses.question-responses');
    }

    public function createResponse(Request $request, $id)
    {
        $this->responseRepository->createResponse($request, $id);
    }

    public function returnResponses()
    {
        return ResponseResource::collection($this->responseRepository->getAll());
    }

    public function deleteContent($id)
    {
        $this->responseRepository->deleteResponse($id);
    }

    public function returnResponse($id)
    {
        $responseAndQuestion = $this->responseRepository->getResponse($id);
        return response()->json([
            'response' => new ResponseResource($responseAndQuestion),
            'question' => new QuestionResource($responseAndQuestion->question),
        ]);
    }
}
