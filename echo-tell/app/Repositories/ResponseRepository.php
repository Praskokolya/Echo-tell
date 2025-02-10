<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResponseRepository
{
    public function __construct(public Response $response, public Question $Question) {}

    public function getAll()
    {
        return $this->response
            ->with('question')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }
    public function createResponse($data, $id)
    {
        $questionAuthor = $this->Question->find($id)->user->id; 
        
        $this->response->create([
            'response' => $data['response'],
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'question_id' => $id,
            'author_id' => $questionAuthor,
            'name_visibility' => $data['name_visibility']
        ]);
    }
    
    public function deleteResponse($id){
        $this->response->destroy($id);
    }

    public function getResponse($id){
        return $this->response->with('question')->find($id);
    }
}
