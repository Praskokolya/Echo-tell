<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view("auth.index");
    }
    public function registation(){
        return view('auth.registation');
    }
    public function create(Request $request){
        dd($request);
    }
}
