<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'response' => fake()->text(),
            'author_id' => 1,
            'question_id' => 2,
            'user_name' => 'dude',
            'user_id' => 2,
            'name_visibility' => 1,
        ];
    }
}
