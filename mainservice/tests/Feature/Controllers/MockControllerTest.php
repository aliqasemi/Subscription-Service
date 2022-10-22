<?php

namespace Tests\Feature\Controllers;

use App\Models\App;
use App\Models\Platform;
use App\Models\Statistic;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MockControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function testGooglePlayMock()
    {
        $response = $this->getJson("/api/mock/google-play");

        $response->assertOk()
            ->assertJsonStructure(['status']);
    }

    public function testAppStoreMock()
    {
        $response = $this->getJson("/api/mock/app-store");

        $response->assertOk()
            ->assertJsonStructure(['subscription']);
    }
}
