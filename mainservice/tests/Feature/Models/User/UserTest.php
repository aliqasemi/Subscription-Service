<?php

namespace Tests\Feature\Models\User;

use App\Models\App;
use App\Models\Platform;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInsertData()
    {
        $user = User::factory(1)->create();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', $user->first()->toArray());
    }

    public function testUserRelationshipWithApps()
    {
        $count = rand(1, 10);

        Platform::factory(2)->create();
        Subscription::factory(4)->create();

        $user = User::factory()->hasApps($count)->create();

        $this->assertCount($count, $user->apps()->get());
        $this->assertTrue($user->apps()->first() instanceof App);
    }

}
