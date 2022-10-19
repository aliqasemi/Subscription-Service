<?php

namespace App\Services;

use App\Jobs\UpdateFailedStatus;
use App\Models\App;
use App\Models\Subscription;
use App\Services\Infrastructure\AbstractHandler;
use Illuminate\Support\Arr;

class DispatchFailedSubscription extends AbstractHandler
{
    private App $app;
    private $newStatusId;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function handle()
    {
        $this->updateFailedStatus();

        $this->setNextAttributes();
    }

    public function updateFailedStatus()
    {
        if ($this->newStatusId == Subscription::$FAILED) {
            UpdateFailedStatus::dispatch($this->app)->delay(now()->addMinutes(Arr::get($this->app->platform()->first(), 'time_minutes_to_resend_http_request')));
        }
    }

    public function setNextAttributes($attr1 = null, $attr2 = null)
    {
        $newSubscription = Subscription::query()->findOrFail($this->newStatusId);
        $this->nextHandler->setAllAttribute($this->newStatusId, $newSubscription);
    }

    public function setAllAttribute($newStatusId, $attr2 = null)
    {
        $this->newStatusId = $newStatusId;
    }
}
