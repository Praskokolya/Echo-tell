<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Repositories\QuestionRepository;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;

class HomePageController extends Controller
{
    public function __construct(public QuestionRepository $questionRepository) 
    {
    }
    public function getHomeData(){
        return Auth::user();
    }
    public function index()
    {
        return view('home.home-page');
    }
}
