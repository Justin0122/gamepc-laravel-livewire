<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactorFactory extends Factory
{
    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/form-factor.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['name'],
            'FormFactorWidth' => $data[$randIndex]['width'],
            'FormFactorDepth' => $data[$randIndex]['depth'],
        ];
    }
}
