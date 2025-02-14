<?php

namespace App\Services;

use App\Repositories\QuestionRepository;
use App\Strategies\MessageStrategy;
use App\Strategies\QuestionStrategy;
use App\Strategies\ResponseStrategy;
use Illuminate\Support\Facades\Auth;

class VerificationService
{
    public function __construct(protected QuestionRepository $questionRepository,)
    {
       
    }
    
    /**
     * @param integer $id ID of content
     * @param string $typeOfContent type of conent (message or question)
     * @return mixed
     */

    public function checkIfUserAuthor(mixed $id, string $typeOfContent){
        $strategy = match ($typeOfContent){
            'question' => new QuestionStrategy,
            'message' => new MessageStrategy,
            'response' => new ResponseStrategy
        }; 
        
        return $strategy->verify($id);
    }
}
