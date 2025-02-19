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

    /**
     * UserRepository constructor.
     *
     * @param \App\Models\User $user
     * @param \App\Services\MailService $mailService
     */
    public function __construct(User $user, MailService $mailService)
    {
        $this->mailService = $mailService;
        $this->user = $user;
    }

    /**
     * Creates a new user from session data.
     *
     * @return \App\Models\User
     */
    public function create()
    {
        return $this->user->create(Session::get('user_array'));
    }

    /**
     * Logs in the user and generates an authentication token.
     *
     * @param array $data
     * @return string|false
     */
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
