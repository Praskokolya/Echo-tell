<?php

namespace App\Repositories;

use App\Models\User;

class ProfileRepository
{
    public function __construct(public User $user) {}

    public function getData($name)
    {
        return $this->user
            ->where('name', $name)
            ->first();
    }
}
