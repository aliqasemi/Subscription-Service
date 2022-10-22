<?php

namespace Tests\Unit;

use App\Models\App;
use App\Models\Subscription;
use App\Services\UpdateFields;
use Tests\TestCase;

class UpdateFieldTest extends TestCase
{
    public function testUpdateApp()
    {
        $object = new UpdateFields(App::query()->first());
        $object->setAllAttribute(Subscription::$EXPIRED, Subscription::query()->findOrFail(Subscription::$EXPIRED));

        $object->updateApp();

        $this->assertEquals(Subscription::$EXPIRED, $object->app->subscription()->first()->id);

        $object->app->delete();
    }
}
