<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public static int $ACTIVE = 1;
    public static int $EXPIRED = 2;
    public static int $PENDING = 3;
    public static int $FAILED = 4;

    public function getTable(): string
    {
        return "subscriptions";
    }

    public function apps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(App::class);
    }

    public function statistics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Statistic::class);
    }
}
