<?php

namespace Database\Factories\Parts;

use Illuminate\Database\Eloquent\Factories\Factory;

class Case_coolerFactory extends Factory
{
    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/case-fan.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['name'],
            'FKBrandId' => fake()->numberBetween(1, 10),
            'Price' => fake()->randomFloat(2, 100, 1000),
            'Stock' => fake()->numberBetween(5, 199)
        ];
    }
}
