<?php

namespace App\Listeners;

use App\Mail\SubscriptionMail;
use Illuminate\Support\Facades\Mail;

class MailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->user)->send(new SubscriptionMail($event->user, $event->subscription));
    }
}
