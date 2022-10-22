<?php

namespace Tests\Feature\Controllers;

use App\Models\App;
use App\Models\Platform;
use App\Models\Statistic;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatisticControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function testStatisticsForAdmin()
    {
        Subscription::factory(4)->create();
        User::factory(1)->create();
        Platform::factory(1)->create();
        App::factory(30)->create();

        Statistic::factory(20)->create();

        $userId = User::query()->first()->id;
        $response = $this->getJson("/api/admin/statistics/$userId");

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'count',
                    'data' => [
                        [
                            'id',
                            'app' => [
                                'id',
                                'name',
                                'platform' => [
                                    'name'
                                ],
                                'user' => [
                                    'name',
                                    'email'
                                ]
                            ]
                        ]
                    ]
                ]
            );
    }
}
