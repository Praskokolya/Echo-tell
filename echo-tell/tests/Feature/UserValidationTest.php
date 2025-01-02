<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Support\Str;
class UserValidationTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     */
    public function test_how_request_validating_data()
    {
        $data = [
            'name' => Str::random(10),
            'email'=> 'nikolay.prasko@gmail.com',
            'password'=> Str::random(12),
        ];

        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->post('/auth/registration/store', $data);

        // dd($response->getStatusCode());
    }
}
