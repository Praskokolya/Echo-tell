<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // SettingSeeder::class,
            // QuestionSeeder::class,
            // UserSeeder::class,
            // ResponseSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
