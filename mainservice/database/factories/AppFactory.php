<?php

namespace Database\Factories;

use App\Models\Platform;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\App>
 */
class AppFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->company(),
            'unique_id' => fake()->buildingNumber(),
            'user_id' => User::all()->random()->id,
            'platform_id' => Platform::all()->random()->id,
            'subscription_id' => Subscription::all()->random()->id,
        ];
    }
}
