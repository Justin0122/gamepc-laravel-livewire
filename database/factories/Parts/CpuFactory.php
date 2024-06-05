<?php

namespace Database\Factories\Parts;

use Illuminate\Database\Eloquent\Factories\Factory;

// Make sure to import your Cpu model

class CpuFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/cpu.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['name'],
            'FKBrandId' => fake()->numberBetween(1, 10),
            'FKGenerationId' => fake()->numberBetween(1, 10),
            'FKSocketId' => fake()->numberBetween(1, 10),
            'Cores' => $data[$randIndex]['core_count'],
            'Threads' => fake()->numberBetween(1, 12),
            'BaseClock' => $data[$randIndex]['core_clock'],
            'BoostClock' => fake()->numberBetween(1, 3),
            'Price' => fake()->randomFloat(2, 100, 1000),
            'Stock' => fake()->numberBetween(5, 199)
        ];
    }
}
