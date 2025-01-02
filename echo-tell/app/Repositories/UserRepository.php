<?php

namespace App\Repositories;

use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\MailService;
use Illuminate\Support\Facades\Session;

class UserRepository
{
    protected $mailService;
    protected $user;
    public function __construct(User $user, MailService $mailService)
    {
        $this->mailService = $mailService;
        $this->user = $user;
    }
    public function create()
    {
        $this->user->create(Session::get('user_array'));
    }
    public function login(array $data)
    {
        $user = $this->user
            ->where($data)
            ->first();
        if($user){
            Auth::login($user);
            $token = $user->createToken('auth_token')->plainTextToken;
            return $token;
        }else{
            return false;
        }
    }
}
