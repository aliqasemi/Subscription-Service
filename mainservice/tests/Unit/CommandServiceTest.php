<?php

namespace Tests\Unit;


use App\Events\MailEvent;
use App\Jobs\UpdateFailedStatus;
use App\Listeners\MailListener;
use App\Models\App;
use App\Models\Subscription;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CommandServiceTest extends TestCase
{
    public function testInit()
    {
        $this->artisan('migrate:fresh --seed');

        $appsActive = App::query()->where('subscription_id', Subscription::$ACTIVE)->get();

        Event::fake();

        Queue::fake();

        $this->artisan('update:status');

        $appsExpired = App::query()->where('subscription_id', Subscription::$EXPIRED)->get();

        $eventsCount = 0;

        foreach ($appsActive as $active) {
            foreach ($appsExpired as $expired) {
                if ($active->id == $expired->id) {
                    $eventsCount++;
                }
            }
        }

        Event::assertDispatched(MailEvent::class, $eventsCount);
        Event::assertListening(MailEvent::class, MailListener::class);
        Queue::assertPushed(UpdateFailedStatus::class);
    }
}
