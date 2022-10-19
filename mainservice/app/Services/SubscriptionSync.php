<?php

namespace App\Services;

use App\Models\App;

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
        $statusFromExtraService = new StatusFromExtraService($this->app);
        $dispatchFailedSubscription = new DispatchFailedSubscription($this->app);
        $updateFields = new UpdateFields($this->app);
        $changeStatusNotification = new ChangeStatusNotification($this->app);

        $statusFromExtraService->setNext($dispatchFailedSubscription)
            ->setNext($updateFields)->setNext($changeStatusNotification);


        foreach ([$statusFromExtraService, $dispatchFailedSubscription, $updateFields, $changeStatusNotification] as $objectiveClass) {
            $objectiveClass->handle();
        }
    }
}
