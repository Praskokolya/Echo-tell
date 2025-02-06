<?php

namespace App\Strategies;

use App\Interfaces\VerificationInterface;
use App\Models\QuestionsModel;
use App\Repositories\QuestionRepository;
use Illuminate\Support\Facades\Auth;

class QuestionStrategy implements VerificationInterface{

     
    public function verify(mixed $id): int
    {
        $question = QuestionsModel::find($id);
        
        if($question->user_id == Auth::id()){
            return 1;
        }

        return 0;
    }

}