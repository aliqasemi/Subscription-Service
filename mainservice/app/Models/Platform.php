<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'response_format_key', 'time_minutes_to_resend_http_request'];

    public static int $GOOGLEPLAY = 1;
    public static int $APPSTORE = 2;

    public function getTable(): string
    {
        return "platforms";
    }

    public function apps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(App::class);
    }
}
