<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionsResource;
use App\Repositories\QuestionRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestionController extends Controller
{

    public function __construct(
        private QuestionRepository $questionRepository,
    ) {}

    public function create(): View
    {
        return view('question.create-question');
    }

    public function index(): View
    {
        return view('question');
    }

    public function questions(): View
    {
        return view('question.questions');
    }

    public function store(Request $request): JsonResponse
    {
        $question = $this->questionRepository
            ->create($request->all());

        return response()->json([
            'question_url' => $question->url,
        ]);
    }

    public function show(int $id): QuestionResource
    {
        $question = $this->questionRepository
            ->get($id);

        return new QuestionResource($question);
    }

    public function returnQuestions(): AnonymousResourceCollection
    {
        return QuestionsResource::collection(
            $this->questionRepository
                ->getAll()
        );
    }

    public function destroy(int $id)
    {
        $this->questionRepository
            ->delete($id);
    }

    public function returnResponses(int $id): JsonResponse
    {
        $question = $this->questionRepository
            ->get($id);
        
        $responses = $this->questionRepository
            ->getQuestionResponses($question);

        return response()->json([
            'responses' => $responses,
            'question' => new QuestionResource($question),
        ]);
    }
}
