<?php

namespace Tests\Unit;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StatisticTest extends TestCase
{
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
