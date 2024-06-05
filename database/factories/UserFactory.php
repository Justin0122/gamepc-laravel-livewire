<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use function Laravel\Prompts\select;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $email = strtolower($first_name[0]).".".strtolower($last_name)."@gmail.com";

        $jsonFilePath = base_path('documentation/json/middlenames.json');
        $jsonContent = file_get_contents($jsonFilePath);
        $randIndex = array_rand($data = json_decode($jsonContent, true), 1);

        return [
            'name' => $first_name,
            'last_name' => $last_name,
            'insertion' => $data[$randIndex]['middle_name'],
            'email' => $email,
            'username' => fake()->unique()->userName(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'street' => fake()->streetName(),
            'house_number' => fake()->numberBetween(1, 255),
            'postcode' => (fake()->numberBetween(1000,9999) . fake()->randomLetter() . fake()->randomLetter()),
            'city' => fake()->city(),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
        ];
    }
}
