<?php

namespace Database\Seeders;

use App\Models\ResponseModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ResponseModel::factory(1)->create();
    }
}
