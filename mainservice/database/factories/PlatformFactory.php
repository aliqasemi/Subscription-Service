<?php

namespace Database\Factories;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Platform>
 */
class PlatformFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        ];
    }

    public function configure()
    {
        return $this->sequence(
            [
                'id' => Platform::$GOOGLEPLAY,
                'name' => 'googlePlay',
                'response_format_key' => 'status',
                'address' => 'http://127.0.0.1:8000/api/mock/google-play',
                'time_minutes_to_resend_http_request' => '60'
            ],
            [
                'id' => Platform::$APPSTORE,
                'name' => 'appStore',
                'response_format_key' => 'subscription',
                'address' => 'http://127.0.0.1:8000/api/mock/app-store',
                'time_minutes_to_resend_http_request' => '120'
            ]
        );
    }
}
