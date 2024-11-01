<?php

namespace Database\Factories;

use App\Models\Decree;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DecreeFactory extends Factory
{
    protected $model = Decree::class;

    public function definition()
    {
        return [
            'number' => $this->faker->unique()->numerify('####'),
            'effective_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'summary' => $this->faker->sentence(10),
            'content' => $this->faker->paragraphs(5, true),
            'doe_number' => $this->faker->numerify('#####'),
            'file_pdf' => 'path/to/fake/pdf.pdf', // Defina um caminho falso para o arquivo PDF
            'user_id' => '1', 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

