<?php

namespace App\Strategies;

use App\Interfaces\VerificationInterface;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;

class ResponseStrategy implements VerificationInterface
{
    public function verify(mixed $id): int
    {
        $response = Response::find($id);
        if (Auth::id() == $response->author_id || Auth::id() == $response->user_id) {
            return 1;
        };
        return 0;
    }
}
