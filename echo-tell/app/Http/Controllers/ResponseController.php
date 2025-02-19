<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Resources\ResponseResource;
use App\Repositories\MessageRepository;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;

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

    /**
     * Show the responses page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('responses.responses');
    }

    /**
     * Show a single response.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showResponse()
    {
        return view('responses.response');
    }

    /**
     * Show the responses for a question.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showQuestionResponses()
    {
        return view('responses.question-responses');
    }

    /**
     * Create a new response to a question.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function createResponse(Request $request, $id)
    {
        $this->responseRepository
            ->createResponse($request, $id);
    }

    /**
     * Return all responses.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function returnResponses()
    {
        return ResponseResource::collection(
            $this->responseRepository
                ->getAll()
        );
    }

    /**
     * Delete a response by its ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteResponse($id)
    {
        $this->responseRepository
            ->delete($id);
    }

    /**
     * Return a specific response and its associated question.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnResponse($id)
    {
        $responseAndQuestion = $this->responseRepository
            ->getResponse($id);

        return response()->json([
            'response' => new ResponseResource($responseAndQuestion),
            'question' => new QuestionResource($responseAndQuestion->question),
        ]);
    }
}
