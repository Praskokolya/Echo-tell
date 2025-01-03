<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Repositories\QuestionRepository;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Symfony\Component\Console\Question\Question;

class HomePageController extends Controller
{
    public function __construct(public QuestionRepository $questionRepository) 
    {
    }
    public function index()
    {
        return view('home.home-page');
    }
    public function createQuestion(Request $request)
    {
        $question = $this->questionRepository->createQuestion($request->all());
        return new QuestionResource($question);
    }
    public function show($id){
        dd($this->questionRepository->getQuestion($id));
    }
}
