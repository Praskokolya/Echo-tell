<?php

namespace App\Http\Middleware;

use App\Services\VerificationService;
use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAuthor
{
    public function __construct(protected VerificationService $verificationService)
    {
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $typeOfContent)
    {
        $status = $this->verificationService->checkIfUserAuthor($request->route('id'), $typeOfContent);

        if($status){
            return $next($request);
        }

        abort(403, "you don't have permission to this " . $typeOfContent);
    }
}
