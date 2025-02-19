<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Repositories\ProfileRepository;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     *
     * @param ProfileRepository $profileRepository
     */
    public function __construct(public ProfileRepository $profileRepository)
    {
    }

    /**
     * Display the profile page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('profile');
    }

    /**
     * Retrieve a user's profile by their name.
     *
     * @param string $name
     * @return ProfileResource
     */
    public function returnUser($name)
    {
        return new ProfileResource(
            $this->profileRepository->getData($name)
        );
    }
}
