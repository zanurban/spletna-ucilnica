<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salt = Str::random(16);

        return [
            'id' => Str::uuid(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt($this->faker->word . $salt), // You can change this to generate hashed passwords
            'salt' => $salt, // Generate a random salt
            'role' => $this->faker->randomElement(['admin', 'user']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
