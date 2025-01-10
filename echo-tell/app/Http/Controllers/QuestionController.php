<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionsResource;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(
        public QuestionRepository $questionRepository,
    ) {}

    public function createQuestion()
    {
        return view('question.create-question');
    }

    public function index()
    {
        return view('question');
    }
    
    public function questions(){
        return view('question.questions');
    }

    // Creating question and returning the question url
    public function create(Request $request)
    {
        $question = $this->questionRepository->createQuestion($request->all());
        return response()->json([
            'question_url' => $question->url,
        ]);
    }
    
    // Returning all question data by id
    public function returnData($id)
    {
        $question = $this->questionRepository->getQuestion($id);
        return new QuestionResource($question);
    }

    public function returnQuestions(){
        return QuestionsResource::collection($this->questionRepository->getAll());
    }
}
