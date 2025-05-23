<?php
// database/seeders/ProjectSeeder.php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::factory()
            ->count(10)
            ->create();
    }
}