<?php

namespace App\Repositories;

use App\Models\QuestionsModel;
use App\Models\ResponseModel;
use Illuminate\Support\Facades\Log;

class NotificationRepository
{
    public function __construct(
        public ResponseModel $responseModel,
        public QuestionsModel $questionsModel

    ) {
    }
    
    // Getting user by hit question id
    
    public function getUserForNotification($id){
        return $this->questionsModel->find($id)->user;
    }
}
