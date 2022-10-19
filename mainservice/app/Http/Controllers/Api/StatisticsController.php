<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatisticResource;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function statistics(User $user)
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $statistics = Statistic::query()
            ->with(['subscription', 'app' => function ($query) use ($user) {
                return $query->with(['user' => function ($q) use ($user) {
                    return $q->where('id', $user->id);
                }, 'platform']);
            }])
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();

        return response()->json([
            'count' => $statistics->count(),
            'data' => StatisticResource::collection($statistics)
        ]);

    }
}
