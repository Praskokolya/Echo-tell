<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    /**
     * HomePageController constructor.
     *
     * @param QuestionRepository $questionRepository
     */
    public function __construct(public QuestionRepository $questionRepository) 
    {
    }

    /**
     * Retrieve the authenticated user's data along with their settings.
     *
     * @return \App\Models\User
     */
    public function getData()
    {
        return Auth::user()->load('settings');
    }

    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('home.home-page');
    }
}
