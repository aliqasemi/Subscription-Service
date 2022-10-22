<?php

namespace Tests\Feature\Models;

use App\Models\App;
use App\Models\Platform;
use App\Models\Statistic;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testInsertData()
    {
        $subscription = Subscription::factory()->create();

        $this->assertDatabaseCount('subscriptions', 1);
        $this->assertDatabaseHas('subscriptions', $subscription->first()->toArray());
    }

    public function testSubscriptionRelationshipWithApps()
    {
        $count = rand(1, 10);

        Platform::factory(2)->create();
        User::factory(1)->create();

        $subscription = Subscription::factory()->hasApps($count)->create();

        $this->assertCount($count, $subscription->apps()->get());
        $this->assertTrue($subscription->apps()->first() instanceof App);
    }

    public function testSubscriptionRelationshipWithStatistics()
    {
        $count = rand(1, 10);

        Platform::factory(2)->create();
        User::factory(1)->create();
        Subscription::factory(3)->create();
        App::factory($count)->create();

        $subscription = Subscription::factory()->sequence(['id' => Subscription::$FAILED, 'status' => Subscription::$FAILED])->hasStatistics($count)->create();

        $this->assertCount($count, $subscription->statistics()->get());
        $this->assertTrue($subscription->statistics()->first() instanceof Statistic);
    }

}
