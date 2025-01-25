<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(public ProfileRepository $profileRepository)
    {
        
    }
    public function index(){
        return view('profile');
    }
    public function returnUser($name){
        return new ProfileResource($this->profileRepository->getData($name));
    }
}
