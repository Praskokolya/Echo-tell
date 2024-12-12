<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function index(){
        return view("auth.index");
    }
    public function registation(){
        return view('auth.registation');
    }
    public function create(Request $request){
        $this->userRepository->create( $request->all() );
    }
}
