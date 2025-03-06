<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;

class ResponseRepository
{

    const RESPONSES_PER_PAGE = 10;

    public function __construct(public Response $response, public Question $question) {}

    public function getAll()
    {
        return $this->response->with('question')->where('user_id', Auth::id())->paginate(self::RESPONSES_PER_PAGE);
    }

    public function createResponse(array $data, int $id)
    {
        // Get the author of the question
        $questionAuthor = $this->question->find($id)->user->id;

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

    public function delete(int $id)
    {
        $this->response->destroy($id);
    }

    public function getResponse(int $id)
    {
        return $this->response->with('question')->find($id);
    }
}
