<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [];
    }

    public function configure()
    {
        return $this->sequence(
            [
                'id' => Subscription::$ACTIVE,
                'status' => Subscription::$ACTIVE
            ],
            [
                'id' => Subscription::$EXPIRED,
                'status' => Subscription::$EXPIRED
            ],
            [
                'id' => Subscription::$PENDING,
                'status' => Subscription::$PENDING
            ],
            [
                'id' => Subscription::$FAILED,
                'status' => Subscription::$FAILED
            ]
        );
    }
}
