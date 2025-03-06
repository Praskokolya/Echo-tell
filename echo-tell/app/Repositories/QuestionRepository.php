<?php

namespace App\Repositories;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuestionRepository
{
    const RESPONSES_PER_PAGE = 6;

    const SLUG_CHARACTER_LIMIT = 50;

    const QUESTIONS_PER_PAGE = 12;

    public function __construct(public Question $questions) {}

    public function create(array $data)
    {
        // Generate a slug from the question text and limit its length
        $slugMessage = Str::slug($data['question'], '-');
        $slugMessage = Str::limit($slugMessage, self::SLUG_CHARACTER_LIMIT, '');
        
        // Create the new question
        $newQuestion = $this->questions->create([
            'question' => $data['question'],
            'slug' => $slugMessage,
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
        ]);

        return $newQuestion;
    }

    public function get(int $id)
    {
        return $this->questions->find($id);
    }

    public function getAll()
    {
        return $this->questions
            ->where('user_id', Auth::id())
            ->withCount('responses')
            ->latest()
            ->paginate(self::QUESTIONS_PER_PAGE);
    }
    public function getQuestionResponses(Question $question)
    {
        return $question->responses()->paginate(self::RESPONSES_PER_PAGE);
    }

    public function checkIfUserAuthor(int $id)
    {
        return $this->questions->find($id)->user_id;
    }

    public function delete(int $id)
    {
        $this->questions->destroy($id);
    }
}
