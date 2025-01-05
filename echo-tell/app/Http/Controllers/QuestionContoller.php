<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Resources\ResponseResource;
use App\Repositories\QuestionRepository;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;

class QuestionContoller extends Controller
{
    public function __construct(
        public QuestionRepository $questionRepository,
        public ResponseRepository $responseRepository
    ) {}
    public function show()
    {
        return view('question');
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
}
