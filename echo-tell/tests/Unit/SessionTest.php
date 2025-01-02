<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SessionTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $data = [
            'name' => 'test1',
            'email' => 'test2',
            'passw' => 'test3',
        ];

        Session::put('user', $data);
        Session::get('user');
    }
}
