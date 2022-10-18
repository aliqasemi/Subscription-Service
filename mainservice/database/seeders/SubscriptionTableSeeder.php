<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::query()->updateOrCreate(
            [
                'id' => Subscription::$ACTIVE,
                'status' => Subscription::$ACTIVE
            ]
        );
        Subscription::query()->updateOrCreate(
            [
                'id' => Subscription::$EXPIRED,
                'status' => Subscription::$EXPIRED
            ]
        );
        Subscription::query()->updateOrCreate(
            [
                'id' => Subscription::$PENDING,
                'status' => Subscription::$PENDING
            ]
        );
        Subscription::query()->updateOrCreate(
            [
                'id' => Subscription::$FAILED,
                'status' => Subscription::$FAILED
            ]
        );
    }
}
