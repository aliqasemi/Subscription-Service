<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Platform::query()->updateOrCreate(
            [
                'id' => Platform::$GOOGLEPLAY,
                'name' => 'googlePlay',
                'response_format_key' => 'status',
                'address' => 'http://127.0.0.1:8000/api/mock/google-play',
                'time_minutes_to_resend_http_request' => '60'
            ]
        );
        Platform::query()->updateOrCreate(
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
