<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubTask;

class SubtaskSeeder extends Seeder
{
    public function run(): void
    {
        SubTask::factory(9000)->create();
    }
}
