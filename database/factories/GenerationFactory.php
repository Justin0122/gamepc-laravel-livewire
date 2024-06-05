<?php

namespace Database\Factories;

use App\Models\Generation;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenerationFactory extends Factory
{
    protected $model = Generation::class;

    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/generations.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['name'],
        ];
    }
}
