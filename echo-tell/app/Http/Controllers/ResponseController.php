<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Resources\ResponseResource;
use App\Repositories\MessageRepository;
use App\Repositories\ResponseRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseController extends Controller
{
    /**
     * ResponseController constructor.
     *
     * @param ResponseRepository $responseRepository
     * @param MessageRepository $messageRepository
     */
    public function __construct(
        public ResponseRepository $responseRepository,
        public MessageRepository $messageRepository
    ) {}

    public function index(): View
    {
        return view('responses.responses');
    }

    public function showResponse(): View
    {
        return view('responses.response');
    }

    public function showQuestionResponses(): View
    {
        return view('responses.question-responses');
    }

    public function store(Request $request,int $id,): void
    {
        $this->responseRepository
            ->createResponse($request->all(), $id);
    }

    public function responses(): AnonymousResourceCollection
    {
        return ResponseResource::collection(
            $this->responseRepository
                ->getAll()
        );
    }

    public function destroy($id,): void
    {
        $this->responseRepository
            ->delete($id);
    }

    public function show($id,): JsonResponse
    {
        $responseAndQuestion = $this->responseRepository
            ->getResponse($id);

        return response()->json([
            'response' => new ResponseResource($responseAndQuestion),
            'question' => new QuestionResource($responseAndQuestion->question),
        ]);
    }
}
