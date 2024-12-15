<?php

namespace Tests\Unit;

use App\Jobs\TestJob;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
class JobDispatchingUsingRedisTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function test_how_job_dispatching_with_redis(){
        // TestJob::dispatch()->delay(now()->addSeconds(5));
    }
}
