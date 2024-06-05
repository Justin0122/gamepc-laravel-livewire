<?php

namespace Database\Factories;

use App\Models\Socket;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocketFactory extends Factory
{
    protected $model = Socket::class;

    public function definition(): array
    {
        $jsonFilePath = base_path('documentation/json/sockets.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'Name' => $data[$randIndex]['socket'],

        ];
    }
}
