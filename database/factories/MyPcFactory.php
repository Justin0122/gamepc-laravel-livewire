<?php

namespace Database\Factories;

use App\Models\MyPc;
use Illuminate\Database\Eloquent\Factories\Factory;

class MyPcFactory extends Factory
{
    protected $model = MyPc::class;

    public function definition(): array
    {
        return [
            'FKUserId' => $this->faker->numberBetween(1, 10),
            'FKCpuId' => $this->faker->numberBetween(1, 10),
            'FKCpuCoolerId' => $this->faker->numberBetween(1, 10),
            'FKMotherboardId' => $this->faker->numberBetween(1, 10),
            'FKRamId' => $this->faker->numberBetween(1, 10),
            'FKStorageId' => $this->faker->numberBetween(1, 10),
            'FKGpuId' => $this->faker->numberBetween(1, 10),
            'FKPsuId' => $this->faker->numberBetween(1, 10),
            'FKCaseId' => $this->faker->numberBetween(1, 10),
        ];
    }
}
