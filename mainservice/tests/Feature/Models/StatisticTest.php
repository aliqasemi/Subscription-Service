<?php

namespace Tests\Feature\Models;

use App\Models\App;
use App\Models\Platform;
use App\Models\Statistic;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatisticTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testInsertData()
    {
        Subscription::factory(4)->create();
        User::factory(1)->create();
        Platform::factory(1)->create();
        App::factory(10)->create();

        $statistics = Statistic::factory(1)->create();

        $this->assertDatabaseCount('statistics', 1);
        $this->assertDatabaseHas('statistics', $statistics->first()->toArray());
    }

    public function testStatisticRelationshipWithSubscription()
    {
        User::factory(1)->create();
        Platform::factory(2)->create();
        Subscription::factory(3)->create();
        App::factory(10)->create();

        $statistics = Statistic::factory()->for(Subscription::factory()->sequence(['id' => Subscription::$FAILED, 'status' => Subscription::$FAILED]))->create();

        $this->assertTrue(isset($statistics->subscription()->first()->id));
        $this->assertTrue($statistics->subscription()->first() instanceof Subscription);
    }

    public function testStatisticRelationshipWithApp()
    {
        User::factory(1)->create();
        Platform::factory(2)->create();
        Subscription::factory(3)->create();
        App::factory(1)->create();

        $statistics = Statistic::factory()->for(App::factory())->create();

        $this->assertTrue(isset($statistics->app()->first()->id));
        $this->assertTrue($statistics->app()->first() instanceof App);
    }
}
