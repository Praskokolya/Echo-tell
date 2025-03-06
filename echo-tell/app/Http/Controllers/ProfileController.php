<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Repositories\ProfileRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(private ProfileRepository $profileRepository) {}

    public function index(): View
    {
        return view('profile');
    }

    public function show(string $name): ProfileResource
    {
        return new ProfileResource(
            $this->profileRepository->get($name)
        );
    }
}
