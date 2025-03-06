<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserRepository
{
    protected $mailService;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create()
    {
        return $this->user->create(Session::get('user_array'));
    }

    public function login(array $data)
    {
        $user = $this->user->where($data)->first();
        if ($user) {
            Auth::logout();
            Auth::login($user);
            return $user->createToken('authToken')->plainTextToken;
        } else {
            return false;
        }
    }
}
