<?php

namespace App\Services;

use App\Events\MailEvent;
use App\Jobs\UpdateFailedStatus;
use App\Models\App;
use App\Models\Statistic;
use App\Models\Subscription;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;

class SubscriptionSync
{
    private App $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public static function BuildAndSync(App $app): void
    {
        (new SubscriptionSync($app))->syncHandler();
    }

    protected function syncHandler(): void
    {
        $newStatusId = $this->getStatusFromExtraService($this->app);

        if ($newStatusId == Subscription::$FAILED) {
            $this->dispatchFailedSubscription($this->app);
        }

        $newSubscription = Subscription::query()->findOrFail($newStatusId);

        $lastStatus = Arr::get($this->app, 'subscription_id');

        $app = $this->updateFields($newStatusId, $newSubscription, $this->app);

        $currentStatus = Arr::get($app, 'subscription_id');

        if ($lastStatus == Subscription::$ACTIVE && $currentStatus == Subscription::$EXPIRED) {
            Event::dispatch(new MailEvent($this->app->user()->first(), $this->app->subscription()->first()));
        }
    }

    private function getStatusFromExtraService(App $app): int
    {
        $response = Http::accept('application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])->get(Arr::get($app, 'platform.address'))->json();

        $ExtraServiceMap = config('map.' . Arr::get($app, 'platform.name'));
        return $ExtraServiceMap[$response[Arr::get($app, 'platform.response_format_key')]];
    }

    private function updateFields(int $newStatusId, $newSubscription, App $app): App
    {
        if ($newStatusId != Subscription::$FAILED) {
            $newSubscription->apps()->save($app);
        }

        if ($newStatusId == Subscription::$EXPIRED) {
            $statistic = Statistic::query()->create();
            $newSubscription->statistics()->save($statistic);
            $app->statistics()->save($statistic);
        }
        return $app;
    }

    private function dispatchFailedSubscription(App $app): void
    {
        UpdateFailedStatus::dispatch($app)->delay(now()->addMinutes(Arr::get($app->platform()->first(), 'time_minutes_to_resend_http_request')));
    }
}
