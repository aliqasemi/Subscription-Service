<?php

namespace App\Services;

use App\Models\App;
use App\Services\Infrastructure\AbstractHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class StatusFromExtraService extends AbstractHandler
{

    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function handle()
    {
        $this->setNextAttributes($this->getPlatform(), $this->getResponse(Arr::get($this->app, 'platform.address')));
    }

    public function getResponse($address)
    {
        return Http::accept('application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])->get($address)->json();
    }

    public function getPlatform()
    {
        return config('map.' . Arr::get($this->app, 'platform.name'));
    }

    public function setNextAttributes($ExtraServiceMap, $response)
    {
        $this->nextHandler->setAllAttribute($ExtraServiceMap[$response[Arr::get($this->app, 'platform.response_format_key')]], null);

    }

    public function setAllAttribute($attr1 = null, $attr2 = null)
    {
    }
}
