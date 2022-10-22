<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatisticTest extends TestCase
{

    public function testInit()
    {
        $this->artisan('migrate:fresh --seed');
        $this->artisan('update:status');

        $this->assertTrue(true);
    }

    public function testStatistics()
    {
        $response = $this->getJson('/api/admin/statistics/1');

        $response->assertJsonStructure([
            'count',
            'data' => [
                [
                    'id',
                    'app' => [
                        'id'
                    ]
                ]
            ]
        ]);
    }
}
