<?php

namespace App\Services;

use Cache;

class MailService
{
    public function generateCode(){
        $code = random_int(100000, 999999);
        Cache::put("code", $code, now()->addMinutes(10));
        // sending mail logic
        
    }
    public function test(){

    }
}
