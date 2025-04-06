<?php

namespace Database\Factories;

use App\Enums\SeverityLevel;
use App\Models\Log;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition()
    {
        $project = Project::inRandomOrder()->first() ?? Project::factory()->create();

        return [
            'project_id' => $project->id,
            'user_id' => $project->user_id, 
            'severity_level' => $this->faker->randomElement(SeverityLevel::cases())->value,
            'message' => $this->faker->sentence(),
        ];
    }
}