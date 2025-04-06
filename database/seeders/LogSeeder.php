<?php

// database/seeders/LogSeeder.php

namespace Database\Seeders;

use App\Models\Log;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    public function run()
    {
        // Kreiraj 50 logova za svaki projekt
        Log::factory()
            ->count(50)
            ->create();
    }
}