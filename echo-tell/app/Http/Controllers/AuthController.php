<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    protected $userRepository;
    protected $userService;

    /**
     * AuthController constructor.
     *
     * @param UserRepository $userRepository
     * @param UserService $userService
     */
    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function index(): View
    {
        return view("auth.index");
    }

    public function registation(): View
    {
        return view('auth.registation');
    }

    public function store(AuthRequest $request)
    {
        $this->userService->storeData($request->all());
    }

    public function passVerificationCode(Request $request): View|RedirectResponse
    {
        if ($this->userService->compareCode($request->code)) {
            return view('welcome');
        } else {
            return redirect()->back();
        }
    }

    public function login(Request $request): JsonResponse
    {
        $accessToken = $this->userRepository->login($request->all());

        if ($accessToken) {
            return response()->json([
                'message' => 'Logged in',
                'access_token' => $accessToken,
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
