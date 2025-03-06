<?php

namespace App\Observers;

use App\Models\Setting;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        Setting::create(['user_id' => $user->id]);
    }

    public function updated(User $user): void
    {
        //
    }

    public function deleted(User $user): void
    {

    }

    public function restored(User $user): void
    {
        //
    }

    public function forceDeleted(User $user): void
    {
        //
    }
}
