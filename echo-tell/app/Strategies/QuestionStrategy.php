<?php

namespace App\Strategies;

use App\Interfaces\VerificationInterface;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionStrategy implements VerificationInterface{

     
    public function verify(mixed $id): int
    {
        $question = Question::find($id);
        
        if($question->user_id == Auth::id()){
            return 1;
        }

        return 0;
    }

}