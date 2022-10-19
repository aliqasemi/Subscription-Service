<?php

namespace App\Services\Infrastructure;

interface Handler
{
    public function setNext(Handler $handler): Handler;
}
