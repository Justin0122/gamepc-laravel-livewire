<?php

namespace Database\Factories\Parts;

use Illuminate\Database\Eloquent\Factories\Factory;

// Make sure to import your Cpu model

class StorageFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/internal-hard-drive.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['name'] . ' ' . $data[$randIndex]['interface'] . ' ' . $data[$randIndex]['type'],
            'StorageCapacity' => $data[$randIndex]['capacity'],
            'StorageSpeed' => fake()->numberBetween(3200, 12800),
            'FKBrandId' => fake()->numberBetween(1, 10),
            'Price' => fake()->randomFloat(2, 100, 1000),
            'Stock' => fake()->numberBetween(5, 199)
        ];
    }
}
