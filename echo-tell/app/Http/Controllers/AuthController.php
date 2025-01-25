<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Jobs\TestJob;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Event\Code\TestMethodBuilder;

class AuthController extends Controller
{
    protected $userRepository;
    protected $userService;

    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }
    public function index()
    {
        return view("auth.index");
    }
    public function registation()
    {
        return view('auth.registation');
    }
    public function store(AuthRequest $request)
    {
        $this->userService->storeData($request->all());
    }
    public function passVerificationCode(Request $request)
    {
        if ($this->userService->compareCode($request->code)) {
            return view('welcome');
        } else {
            return redirect()->back();
        }
    }
    public function login(Request $request)
    {
        $accessToken = $this->userRepository->login($request->all());
        if ($accessToken ) {
            return response()->json([
                'message' => 'Logged in',
                'access_token' => $accessToken ,
                'redirect_url' => '/home',
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid name or password',
                'status' => 401,
            ]);  
        }
    }
}
