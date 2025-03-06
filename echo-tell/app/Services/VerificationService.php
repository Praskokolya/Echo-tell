<?php

namespace App\Services;

use App\Repositories\QuestionRepository;
use App\Strategies\MessageStrategy;
use App\Strategies\QuestionStrategy;
use App\Strategies\ResponseStrategy;

class VerificationService
{
    public function __construct(protected QuestionRepository $questionRepository,)
    {
       
    }
    
    public function checkIfUserAuthor(mixed $id, string $typeOfContent): bool{
        $strategy = match ($typeOfContent){
            'question' => new QuestionStrategy,
            'message' => new MessageStrategy,
            'response' => new ResponseStrategy
        }; 
        
        return $strategy->verify($id);
    }
}
