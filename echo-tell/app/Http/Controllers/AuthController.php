<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;


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

    /**
     * Display the authentication index page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view("auth.index");
    }

    /**
     * Display the registration page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function registation()
    {
        return view('auth.registation');
    }

    /**
     * Store a new user.
     *
     * @param AuthRequest $request
     * @return void
     */
    public function store(AuthRequest $request)
    {
        $this->userService->storeData($request->all());
    }

    /**
     * Verify the provided verification code.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function passVerificationCode(Request $request)
    {
        if ($this->userService->compareCode($request->code)) {
            return view('welcome');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Authenticate the user and return an access token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
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
