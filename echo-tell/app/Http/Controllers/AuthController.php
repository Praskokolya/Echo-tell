<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Services\UserServiceService;
use Illuminate\Http\Request;
use PHPUnit\Event\Code\TestMethodBuilder;

class AuthController extends Controller
{
    protected $userRepository;
    protected $userService;
    public function __construct(UserRepository $userRepository, UserService $userService){
        $this->userRepository = $userRepository;
        $this->userService = $userService;  
    }

    public function index(){
        TestJob::dispatch();
        return view("auth.index");
    }
    public function registation()   {
        return view('auth.registation');
    } 
    public function store(Request $request){
        $this->userService->storeUserData($request->all());
        return redirect()->route('verify.form');
    }
}
