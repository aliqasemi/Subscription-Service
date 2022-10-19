<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class MockController extends Controller
{
    public function googlePlay(): \Illuminate\Http\JsonResponse
    {
        $statuses = ["active", "expired", "pending", "failed"];
        $status = $statuses[rand(0, 3)];
        if ($status != "failed") {
            return response()->json([
                'status' => $status,
            ], 200);
        } else {
            return response()->json([
                'status' => $status,
            ], 500);
        }
    }

    public function appStore(): \Illuminate\Http\JsonResponse
    {
        $statuses = ["active", "expired", "pending", "failed"];
        $status = $statuses[rand(0, 3)];
        if ($status != "failed") {
            return response()->json([
                'subscription' => $status,
            ], 200);
        } else {
            return response()->json([
                'subscription' => $status,
            ], 500);
        }
    }
}
