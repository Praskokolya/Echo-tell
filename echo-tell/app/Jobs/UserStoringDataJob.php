<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Session;

class UserStoringDataJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $userData;
    public function __construct(array $userData)
    {
        $this->userData = $userData; 
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Session::put("user_array", $this->userData);
    }
}
