<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResponseRepository
{
    /**
     * Number of responses per page for pagination.
     */
    const RESPONSES_PER_PAGE = 10;

    /**
     * Constructor to initialize Response and Question models.
     *
     * @param \App\Models\Response $response
     * @param \App\Models\Question $Question
     */
    public function __construct(public Response $response, public Question $Question) {}

    /**
     * Retrieves all responses for the authenticated user.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return $this->response
            ->with('question')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(self::RESPONSES_PER_PAGE);
    }

    /**
     * Creates a new response for a question.
     *
     * @param array $data Response data
     * @param int $id Question ID
     * @return void
     */
    public function createResponse(array $data, int $id)
    {
        // Get the author of the question
        $questionAuthor = $this->Question->find($id)->user->id;

        // Create a new response
        $this->response->create([
            'response' => $data['response'],
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'question_id' => $id,
            'author_id' => $questionAuthor,
            'name_visibility' => $data['name_visibility']
        ]);
    }

    /**
     * Deletes a response by its ID.
     *
     * @param int $id Response ID
     * @return void
     */
    public function delete(int $id)
    {
        $this->response->destroy($id);
    }

    /**
     * Retrieves a specific response by its ID.
     *
     * @param int $id Response ID
     * @return \App\Models\Response|null
     */
    public function getResponse(int $id)
    {
        return $this->response->with('question')->find($id);
    }
}
