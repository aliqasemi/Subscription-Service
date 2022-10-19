<?php

namespace App\Services;

use App\Models\App;
use App\Models\Statistic;
use App\Models\Subscription;
use App\Services\Infrastructure\AbstractHandler;
use Illuminate\Support\Arr;

class UpdateFields extends AbstractHandler
{

    private int $newStatusId;
    private $newSubscription;
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function handle()
    {
        $lastStatus = Arr::get($this->app, 'subscription_id');

        if ($this->newStatusId != Subscription::$FAILED) {
            $this->newSubscription->apps()->save($this->app);
        }

        if ($this->newStatusId == Subscription::$EXPIRED) {
            $statistic = Statistic::query()->create();
            $this->newSubscription->statistics()->save($statistic);
            $this->app->statistics()->save($statistic);
        }

        $currentStatus = Arr::get($this->app, 'subscription_id');

        $this->nextHandler->setAllAttribute($lastStatus, $currentStatus);
        $this->nextHandler->setApp($this->app);
    }

    public function setAllAttribute($newStatusId, $newSubscription)
    {
        $this->newStatusId = $newStatusId;
        $this->newSubscription = $newSubscription;
    }
}
