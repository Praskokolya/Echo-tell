<?php

namespace App\Services;

use App\Jobs\UserStoringDataJob;
use App\Mail\SendCodeMail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserService
{
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param \App\Repositories\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Generates a 6-digit random code and stores it in the cache.
     *
     * @return void
     */
    protected function generateCode()
    {
        $code = random_int(100000, 999999);
        Cache::put("code", $code, now()->addMinutes(10));
    }

    /**
     * Stores user data in the session and sends a verification code to the provided email.
     *
     * @param array $userData
     * @return void
     */
    public function storeData(array $userData): void
    {
        Session::put("user_array", $userData);
        $this->sendCode($userData['email']);
    }

    /**
     * Sends a verification code to the user's email.
     *
     * @param string $mail
     * @return void
     */
    protected function sendCode($mail)
    {
        $this->generateCode();
        Mail::to($mail)->queue(new SendCodeMail());
    }

    /**
     * Compares the entered code with the stored code and creates the user if the codes match.
     *
     * @param int $enteredCode
     * @return bool
     */
    public function compareCode($enteredCode)
    {
        if ($enteredCode == Cache::get("code")) {
            $this->userRepository->create();
            return true;
        } else {
            Session::flash('error', 'Wrong verification code');
            return false;
        }
    }
}
