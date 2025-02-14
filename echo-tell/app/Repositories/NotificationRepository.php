<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationRepository
{
    public function __construct(
        public Response $Response,
        public Question $Question,
        public User $user
    ) {
    }
    
    // Getting user by his question id
    
    public function getUserForNotification($id){
        return $this->user->find($id);
    }

    public function getAll(){
        return Auth::user()->notifications()->paginate(8);
    }
}
