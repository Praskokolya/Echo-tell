<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationRepository
{
    /**
     * Number of notifications per page for pagination.
     */
    const NOTIFICATIONS_PER_PAGE = 8;

    /**
     * Constructor to initialize Response, Question, and User models.
     *
     * @param \App\Models\Response $Response
     * @param \App\Models\Question $Question
     * @param \App\Models\User $user
     */
    public function __construct(
        public Response $Response,
        public Question $Question,
        public User $user
    ) {}

    /**
     * Retrieves a user by their question ID.
     *
     * @param int $id Question ID
     * @return \App\Models\User|null
     */
    public function getUserForNotification(int $id)
    {
        return $this->user->find($id);
    }

    /**
     * Retrieves all notifications for the authenticated user.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Auth::user()->notifications()
            ->paginate(self::NOTIFICATIONS_PER_PAGE);
    }
}
