<?php

namespace Tests\Feature\Models\User;

use App\Models\App;
use App\Models\Platform;
use App\Models\Statistic;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testInsertData()
    {
        Subscription::factory(4)->create();
        User::factory(1)->create();
        Platform::factory(1)->create();

        $user = App::factory(1)->create();

        $this->assertDatabaseCount('apps', 1);
        $this->assertDatabaseHas('apps', $user->first()->toArray());
    }

    public function testAppRelationshipWithStatistics()
    {
        $count = rand(1, 10);

        Subscription::factory(4)->create();
        User::factory(1)->create();
        Platform::factory(1)->create();

        $app = App::factory()->hasStatistics($count)->create();

        $this->assertCount($count, $app->statistics()->get());
        $this->assertTrue($app->statistics()->first() instanceof Statistic);
    }

    public function testAppRelationshipWithSubscription()
    {
        User::factory(1)->create();
        Platform::factory(2)->create();
        Subscription::factory(3)->create();

        $app = App::factory()->for(Subscription::factory()->sequence(['id' => Subscription::$FAILED, 'status' => Subscription::$FAILED]))->create();

        $this->assertTrue(isset($app->subscription()->first()->id));
        $this->assertTrue($app->subscription()->first() instanceof Subscription);
    }

    public function testAppRelationshipWithPlatform()
    {
        User::factory(1)->create();
        Subscription::factory(4)->create();
        Platform::factory(1)->create();

        $app = App::factory()->for(Platform::factory()->sequence(
            [
                'id' => Platform::$APPSTORE,
                'name' => 'appStore',
                'response_format_key' => 'subscription',
                'address' => 'http://127.0.0.1:8000/api/mock/app-store',
                'time_minutes_to_resend_http_request' => '120'
            ]
        ))->create();

        $this->assertTrue(isset($app->platform()->first()->id));
        $this->assertTrue($app->platform()->first() instanceof Platform);
    }

    public function testAppRelationshipWithUser()
    {
        Platform::factory(2)->create();
        Subscription::factory(4)->create();
        User::factory(1)->create();

        $app = App::factory()->for(User::query()->create(['name' => 'ali', 'email' => 'qasemi@gmail.com']))->create();

        $this->assertTrue(isset($app->user()->first()->id));
        $this->assertTrue($app->user()->first() instanceof User);
    }
}
