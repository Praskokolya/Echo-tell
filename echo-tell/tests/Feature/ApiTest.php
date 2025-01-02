<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    const API_TOKEN = '14|P4ycNpplEx3sis3Welr1yTuQ3iZuDMA3I9WdMUGNdc116ed0';
    /**
     * A basic feature test example.
     */
    public function test_what_response_return_protected_route()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::API_TOKEN,
        ])->get('/api/get');
        $response->assertStatus(200);
    }
}
