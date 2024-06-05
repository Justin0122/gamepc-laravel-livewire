<?php

namespace Database\Factories\Parts;

use Illuminate\Database\Eloquent\Factories\Factory;

class Cpu_coolerFactory extends Factory
{
    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/cpu-cooler.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['name'],
            'FKSocketId' => fake()->numberBetween(1, 10),
            'FKBrandId' => fake()->numberBetween(1, 10),
            'FKGenerationId' => fake()->numberBetween(1, 10),
            'Price' => fake()->randomFloat(2, 100, 1000),
            'Stock' => fake()->numberBetween(5, 199)
        ];
    }
}
