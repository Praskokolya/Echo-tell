<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionsResource;
use App\Http\Resources\ResponseResource;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * QuestionController constructor.
     *
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        public QuestionRepository $questionRepository,
    ) {}

    /**
     * Show the page for creating a question.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function createQuestion()
    {
        return view('question.create-question');
    }

    /**
     * Show the main question page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('question');
    }

    /**
     * Show the page displaying all questions.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function questions()
    {
        return view('question.questions');
    }

    /**
     * Create a new question and return the question URL.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $question = $this->questionRepository
            ->createQuestion($request->all());

        return response()->json([
            'question_url' => $question->url,
        ]);
    }

    /**
     * Return data for a specific question by its ID.
     *
     * @param int $id
     * @return QuestionResource
     */
    public function returnData($id)
    {
        $question = $this->questionRepository
            ->getQuestion($id);

        return new QuestionResource($question);
    }

    /**
     * Return all questions.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function returnQuestions()
    {
        return QuestionsResource::collection(
            $this->questionRepository
                ->getAll()
        );
    }

    /**
     * Delete a question by its ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteQuestion(int $id)
    {
        $this->questionRepository
            ->delete($id);
    }

    /**
     * Return all responses for a specific question by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnQuestionResponses($id)
    {
        $question = $this->questionRepository
            ->getQuestion($id);
        
        $responses = $this->questionRepository
            ->getQuestionResponses($question);

        return response()->json([
            'responses' => $responses,
            'question' => new QuestionResource($question),
        ]);
    }
}
