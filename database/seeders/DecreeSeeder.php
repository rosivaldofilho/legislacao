<?php

namespace Database\Seeders;

use App\Models\Decree;
use Illuminate\Database\Seeder;

class DecreeSeeder extends Seeder
{
    public function run()
    {
        // Cria 10 registros de decretos usando o factory
        Decree::factory()->count(50)->create();
    }
}
