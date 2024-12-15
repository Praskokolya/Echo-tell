<?php

namespace App\Services;

use App\Mail\SendCodeMail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserService
{
    protected function generateCode(){
        $code = random_int(100000, 999999);
        Cache::put("code", $code, now()->addMinutes(10));       
    }

    public function storeUserData(array $userData){
        
        Session::put("user_array", $userData);
        $this->sendUserCode($userData['email']);
    }

    protected function sendUserCode($mail){
        self::generateCode();
        Mail::to($mail)->send(new SendCodeMail());
    }
}
