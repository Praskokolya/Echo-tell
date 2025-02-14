<?php

namespace App\Repositories;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuestionRepository
{
    const RESPONSES_PER_PAGE = 6; 

    public function __construct(public Question $questions) {}

    public function createQuestion($data)
    {
        $slugMessage = Str::slug($data['question'], '-');
        $slugMessage = Str::limit($slugMessage, 50, '');
        $newQuestion = $this->questions->create([
            'question' => $data['question'],
            'slug' => $slugMessage,
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
        ]);
        return $newQuestion;
    }
    public function getQuestion($id)
    {
        return $this->questions->find($id);
    }

    public function getAll()
    {
        return $this->questions
            ->where('user_id', Auth::id())
            ->withCount('responses')
            ->latest()
            ->paginate(12);
    }

    public function getQuestionResponses($question){
        return $question->responses()->paginate(self::RESPONSES_PER_PAGE);
    }

    public function checkIfUserAuthor($id){
        return $this->questions->find($id)->user_id;
    }
}
