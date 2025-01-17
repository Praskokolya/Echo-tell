<?php

namespace App\Repositories;

use App\Models\QuestionsModel;
use App\Models\ResponseModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationRepository
{
    public function __construct(
        public ResponseModel $responseModel,
        public QuestionsModel $questionsModel

    ) {
    }
    
    // Getting user by his question id
    
    public function getUserForNotification($id){
        return $this->questionsModel->find($id)->user;
    }

    public function getAll(){
        // Didn't use Auth::user() beacause my IDE showing problem with calling notifications() on it
        $user = User::find(Auth::user()->id);
        return $user->notifications()->paginate(8);
    }
}
