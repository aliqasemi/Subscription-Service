<?php

namespace App\Console\Commands;

use App\Models\App;
use App\Models\Statistic;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class RepeatCheckingFailedSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'failed:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repeat checking failed subscription';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $statistics = Statistic::with('app.platform', 'subscription')->get();

        foreach ($statistics as $statistic) {
            if (Arr::get($statistic, 'subscription.id') == Subscription::$FAILED) {
                if (Arr::get($statistic, 'updated_at') > Arr::get($statistic, 'app.platform.time_minutes_to_resend_http_request')) {
                    $newStatusId = $this->getStatusFromExtraService(Arr::get($statistic, 'app'));
                    $newSubscription = Subscription::query()->findOrFail($newStatusId);
                    $this->updateFields($newStatusId, $newSubscription, Arr::get($statistic, 'app'), $statistic);
                }
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

    public function updateFields(int $newStatusId, $newSubscription, App $app, Statistic $statistic)
    {
        if ($newStatusId != Subscription::$FAILED) {
            $newSubscription->apps()->save($app);
        }

        if ($newStatusId == Subscription::$FAILED || $newStatusId == Subscription::$EXPIRED) {
            $newSubscription->statistics()->save($statistic);
            $app->statistics()->save($statistic);
        }
    }
}
