<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        return view('home.home-page');
    }
    public function createMessage(Request $request)
    {
        return response()->json([
            'message' => $request->all(),
            'status' => 200,
        ]);
    }
}
