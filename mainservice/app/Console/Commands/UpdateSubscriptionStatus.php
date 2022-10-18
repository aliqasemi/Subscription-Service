<?php

namespace App\Console\Commands;

use App\Models\App;
use App\Models\Statistic;
use App\Models\Subscription;
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
            $newStatusId = $this->getStatusFromExtraService($app);

            $newSubscription = Subscription::query()->findOrFail($newStatusId);

            $lastStatus = Arr::get($app, 'subscription_id');

            $app = $this->updateFields($newStatusId, $newSubscription, $app);

            $currentStatus = Arr::get($app, 'subscription_id');

            if ($lastStatus == Subscription::$ACTIVE && $currentStatus == Subscription::$EXPIRED) {
                // send email
            }
        }
    }

    public function getStatusFromExtraService(App $app): int
    {
        $response = Http::accept('application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])->get(Arr::get($app, 'platform.address'))->json();

        $ExtraServiceMap = config('map.' . Arr::get($app, 'platform.name'));
        return $ExtraServiceMap[$response[Arr::get($app, 'platform.response_format_key')]];
    }

    public function updateFields(int $newStatusId, $newSubscription, App $app): App
    {
        if ($newStatusId != Subscription::$FAILED) {
            $newSubscription->apps()->save($app);
        }

        if ($newStatusId == Subscription::$FAILED || $newStatusId == Subscription::$EXPIRED) {
            $statistic = Statistic::query()->create();
            $newSubscription->statistics()->save($statistic);
            $app->statistics()->save($statistic);
        }
        return $app;
    }
}
