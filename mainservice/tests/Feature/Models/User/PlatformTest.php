<?php

namespace Tests\Feature\Models\User;

use App\Models\App;
use App\Models\Platform;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testInsertData()
    {
        $platform = Platform::factory(1)->create();

        $this->assertDatabaseCount('platforms', 1);
        $this->assertDatabaseHas('platforms', $platform->first()->toArray());
    }

    public function testPlatformRelationshipWithApps()
    {
        $count = rand(1, 10);

        Subscription::factory(4)->create();
        User::factory(1)->create();

        $platform = Platform::factory()->hasApps($count)->create();

        $this->assertCount($count, $platform->apps()->get());
        $this->assertTrue($platform->apps()->first() instanceof App);
    }
}
