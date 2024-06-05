<?php

namespace Database\Factories\Parts;

use Illuminate\Database\Eloquent\Factories\Factory;

// Make sure to import your Cpu model

class SocketFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/sockets.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);


        return [
            'SocketName' => $data[$randIndex]['socket'],
            'Stock' => fake()->numberBetween(5, 199)
        ];
    }
}
