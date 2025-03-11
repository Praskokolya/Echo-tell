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
    public function loginWithGoogle($googleData){
        $user = $this->user->where('google_id', $googleData->id)->first();
        if($user){
            Auth::login($user);
            return $user->createToken('authToken')->plainTextToken;
        };
        if(!$user){
            $this->user->create([
                'name' => $googleData->name,
                'email' => $googleData->email,
                'google_id' => $googleData->id
            ]);
        };
    }
}
