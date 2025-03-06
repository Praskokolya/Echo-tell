<?php

namespace App\Observers;

use App\Models\Question;

class QuestionObserver
{
    public function deleted(Question $question): void
    {
        $question->responses()->delete();
    }
}
