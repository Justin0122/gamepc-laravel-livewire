<?php

namespace Database\Factories\Parts;

use Illuminate\Database\Eloquent\Factories\Factory;

class RamFactory extends Factory
{
    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/memory.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['name'],
            'Capacity' => fake()->numberBetween(1666, 5622),
            'FKMemoryTypeId' => fake()->numberBetween(1, 4),
            'FKBrandId' => fake()->numberBetween(1, 10),
            'Stock' => fake()->numberBetween(5, 199),
            'Price' => fake()->randomFloat(2, 100, 1000),
        ];
    }
}
