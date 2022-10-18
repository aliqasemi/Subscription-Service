<?php

namespace Database\Factories;

use App\Models\Platform;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'user_id' => User::query()->first('id'),
            'platform_id' => rand(1, Platform::query()->count()),
            'subscription_id' => rand(1, Subscription::query()->count() - 1),
        ];
    }
}
