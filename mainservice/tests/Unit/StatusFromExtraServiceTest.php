<?php

namespace Tests\Unit;

use App\Models\App;
use App\Models\Platform;
use App\Models\Subscription;
use App\Services\StatusFromExtraService;
use Tests\TestCase;

class StatusFromExtraServiceTest extends TestCase
{
    public function testResponseExtraService()
    {
        $app = new App(['name' => 'telegram', 'user_id' => 1, 'platform_id' => Platform::$GOOGLEPLAY, 'subscription_id' => Subscription::$ACTIVE]);

        $object = new StatusFromExtraService($app);

        $response = $object->getResponse("http://127.0.0.1:8000/api/mock/app-store");

        $this->assertArrayHasKey('subscription', $response);

        $response = $object->getResponse("http://127.0.0.1:8000/api/mock/google-play");

        $this->assertArrayHasKey('status', $response);
    }
}
