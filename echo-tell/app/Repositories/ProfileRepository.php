<?php

namespace App\Repositories;

use App\Models\User;

class ProfileRepository
{
    public function __construct(public User $user) {}

    public function get($name)
    {
        return $this->user
            ->where('name', $name)
            ->first();
    }
}
