<?php

namespace App\Repositories;

use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Services\MailService;
use Auth;

class UserRepository
{   
    protected $mailService;
    protected $user;
    public function __construct(User $user, MailService $mailService) {
        $this->mailService = $mailService;
        $this->user = $user;
    }
    public function create(array $userData){
        
    }
}
