<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientInfo>
 */
class ClientInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'invoice' => fake()->numberBetween(1000, 9999),
            'company_name' => fake()->company(),
            'domain' => fake()->domainName(),
            'telephone' => fake()->phoneNumber(),
        ];
    }
}
