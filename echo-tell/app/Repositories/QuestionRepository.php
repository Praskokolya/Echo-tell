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
    /**
     * Number of responses per page for pagination.
     */
    const RESPONSES_PER_PAGE = 6;

    /**
     * Character limit for question slug.
     */
    const SLUG_CHARACTER_LIMIT = 50;

    /**
     * Number of questions per page for pagination.
     */
    const QUESTIONS_PER_PAGE = 12;

    /**
     * Constructor to initialize Question model.
     *
     * @param \App\Models\Question $questions
     */
    public function __construct(public Question $questions) {}

    /**
     * Creates a new question with the given data.
     *
     * @param array $data
     * @return \App\Models\Question
     */
    public function createQuestion(array $data)
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

    /**
     * Retrieves a specific question by its ID.
     *
     * @param int $id Question ID
     * @return \App\Models\Question|null
     */
    public function getQuestion(int $id)
    {
        return $this->questions->find($id);
    }

    /**
     * Retrieves all questions for the authenticated user.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->questions
            ->where('user_id', Auth::id())
            ->withCount('responses')
            ->latest()
            ->paginate(self::QUESTIONS_PER_PAGE);
    }

    /**
     * Retrieves the responses for a specific question.
     *
     * @param \App\Models\Question $question
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getQuestionResponses(Question $question)
    {
        return $question->responses()->paginate(self::RESPONSES_PER_PAGE);
    }

    /**
     * Checks if the authenticated user is the author of the question.
     *
     * @param int $id Question ID
     * @return int|null User ID of the question author
     */
    public function checkIfUserAuthor(int $id)
    {
        return $this->questions->find($id)->user_id;
    }

    /**
     * Deletes a specific question by its ID.
     *
     * @param int $id Question ID
     * @return void
     */
    public function delete(int $id)
    {
        $this->questions->destroy($id);
    }
}
