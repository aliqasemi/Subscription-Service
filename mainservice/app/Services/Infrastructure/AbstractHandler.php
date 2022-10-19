<?php

namespace App\Services\Infrastructure;

abstract class AbstractHandler implements Handler
{
    protected Handler $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;
        return $this->nextHandler;
    }

    public abstract function handle();

    public abstract function setAllAttribute($attr1, $attr2);

    public abstract function setNextAttributes($attr1, $attr2);
}
