<?php

namespace App\Repositories;

use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Services\MailService;
use Auth;
use Cache;
use Session;

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
        $data['password'] = bcrypt($data['password']);
        $user = $this->user
            ->where($data)
            ->first();
        if($user){
            Auth::login($user);
            return true;
        }else{
            return false;
        }
    }
}
