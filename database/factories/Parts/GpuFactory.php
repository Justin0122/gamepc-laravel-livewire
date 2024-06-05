<?php

namespace Database\Factories\Parts;

use Illuminate\Database\Eloquent\Factories\Factory;

// Make sure to import your Cpu model

class GpuFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/video-card.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['chipset'],
            'FKBrandId' => fake()->numberBetween(1, 10),
            'FKMemoryTypeId' => fake()->numberBetween(1, 6),
            'MemoryInterface' => fake()->numberBetween(1, 10),
            'MemoryBandwidth' => $data[$randIndex]['memory'],
            'Memory' => $data[$randIndex]['memory'],
            'BaseClock' => fake()->numberBetween(1, 10),
            'BoostClock' => fake()->numberBetween(1, 10),
            'Price' => fake()->randomFloat(2, 100, 1000),
            'Stock' => fake()->numberBetween(5, 199)
        ];
    }
}
