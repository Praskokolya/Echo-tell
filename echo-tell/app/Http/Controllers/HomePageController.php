<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{ 
    public function user(): User
    {
        return Auth::user()->load('settings');
    }

    public function index(): View
    {
        return view('home.home-page');
    }
}
