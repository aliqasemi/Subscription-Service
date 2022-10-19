<?php

namespace App\Console\Commands;

use App\Models\App;
use App\Models\Statistic;
use App\Models\Subscription;
use App\Services\SubscriptionSync;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class UpdateSubscriptionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update subscription status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apps = App::query()->with('platform')->get();

        foreach ($apps as $app) {
            SubscriptionSync::BuildAndSync($app);
        }
    }
}
