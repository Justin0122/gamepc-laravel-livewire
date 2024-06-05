<?php

namespace Database\Factories;

use App\Models\MemoryType;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemoryTypeFactory extends Factory
{
    protected $model = MemoryType::class;

    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/memory-types.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['name'],
            'MemoryTypeSpeed' => $data[$randIndex]['speed'],
        ];
    }
}
