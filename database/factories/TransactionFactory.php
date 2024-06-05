<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'FKUserId' => $this->faker->numberBetween(1, 10),
            'FKMyPcId' => $this->faker->numberBetween(1, 10),
            'total_price' => $this->faker->randomFloat(2, 0, 999999.99),
            'status' => $this->faker->randomElement(['pending', 'shipped', 'delivered', 'cancelled', 'refunded']),
            'payment_method' => $this->faker->randomElement(['ideal', 'paypal', 'creditcard', 'klarna']),
            'shipped_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'delivered_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'cancelled_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'refunded_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
