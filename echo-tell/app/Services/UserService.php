<?php

namespace App\Services;

use App\Mail\SendCodeMail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    protected function generateCode()
    {
        $code = random_int(100000, 999999);
        Cache::put("code", $code, now()->addMinutes(10));
    }

    public function storeData(array $userData): void
    {
        Session::put("user_array", $userData);
        $this->sendCode($userData['email']);
    }

    protected function sendCode($mail)
    {
        $this->generateCode();
        Mail::to($mail)->queue(new SendCodeMail());
    }

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
