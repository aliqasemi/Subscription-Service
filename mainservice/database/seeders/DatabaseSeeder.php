<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(SubscriptionTableSeeder::class);
        $this->call(PlatformTableSeeder::class);
        $this->call(SubscriptionTableSeeder::class);
        $this->call(AppTableSeeder::class);
    }
}
