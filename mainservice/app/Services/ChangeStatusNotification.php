<?php

namespace App\Services;

use App\Events\MailEvent;
use App\Models\App;
use App\Models\Subscription;
use App\Services\Infrastructure\AbstractHandler;
use Illuminate\Support\Facades\Event;

class ChangeStatusNotification extends AbstractHandler
{
    private int $currentStatus;
    private int $lastStatus;
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function handle()
    {
        $this->sendNotification();
    }

    public function sendNotification()
    {
        if ($this->lastStatus == Subscription::$ACTIVE && $this->currentStatus == Subscription::$EXPIRED) {
            Event::dispatch(new MailEvent($this->app->user()->first(), $this->app->subscription()->first()));
        }
    }

    public function setAllAttribute($lastStatus, $currentStatus)
    {
        $this->lastStatus = $lastStatus;
        $this->currentStatus = $currentStatus;
    }

    public function setApp($app)
    {
        $this->app = $app;
    }

    public function setNextAttributes($attr1, $attr2)
    {
    }
}
