<?php

namespace Database\Factories\Parts;

use Illuminate\Database\Eloquent\Factories\Factory;

// Make sure to import your Cpu model

class MotherboardFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/motherboard.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['name'],
            'FKSocketId' => fake()->numberBetween(1, 10),
            'FKMemoryTypeId' => fake()->numberBetween(1, 6),
            'FKFormFactorId' => fake()->numberBetween(1, 10),
            'FKBrandId' => fake()->numberBetween(1, 10),
            'MemoryCapacity' => $data[$randIndex]['max_memory'],
            'USBPorts' => fake()->numberBetween(1, 4),
            'PCIeSlots' => $data[$randIndex]['memory_slots'],
            'Price' => fake()->randomFloat(2, 100, 1000),
            'Stock' => fake()->numberBetween(5, 199)
        ];
    }
}
