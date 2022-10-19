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
        $response = Http::accept('application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])->get(Arr::get($this->app, 'platform.address'))->json();

        $ExtraServiceMap = config('map.' . Arr::get($this->app, 'platform.name'));
        $this->nextHandler->setAllAttribute($ExtraServiceMap[$response[Arr::get($this->app, 'platform.response_format_key')]], null);
    }

    public function setAllAttribute($attr1 = null, $attr2 = null)
    {
    }
}
