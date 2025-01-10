<?php

namespace Tests\Unit;

use App\Models\User;
use App\Notifications\NewResponseNotification;
use PHPUnit\Framework\TestCase;

class CreateNotificationTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $user = User::find(8); 
        $user->notify(new NewResponseNotification('111'));
        dd($user->notifications);
    }
}
