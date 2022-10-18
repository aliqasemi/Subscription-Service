<?php

return [
    'googlePlay' => [
        'active' => \App\Models\Subscription::$ACTIVE,
        'expired' => \App\Models\Subscription::$EXPIRED,
        'pending' => \App\Models\Subscription::$PENDING,
        'failed' => \App\Models\Subscription::$FAILED
    ],
    'appStore' => [
        'active' => \App\Models\Subscription::$ACTIVE,
        'expired' => \App\Models\Subscription::$EXPIRED,
        'pending' => \App\Models\Subscription::$PENDING,
        'failed' => \App\Models\Subscription::$FAILED
    ]
];
