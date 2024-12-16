<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
class UserValidationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_how_request_validating_data(): void
    {
        $data = [
            'name' => Str::random(17),
            'email'=> 'test@gmail.com',
            'password'=> bcrypt('123'),
        ];
        $response = $this->post('/auth/registration/store', $data);
        $response->assertStatus(200);
    }
}
