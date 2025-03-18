<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationRepository
{
    const NOTIFICATIONS_PER_PAGE = 8;

    
    public function __construct(
        public Response $Response,
        public Question $Question,
        public User $user
    ) {}

    public function getUserForNotification(int $id)
    {
        return $this->user->find($id);
    }

    public function getAll()
    {
        return Auth::user()->notifications()
            ->paginate(self::NOTIFICATIONS_PER_PAGE);
    }
}
