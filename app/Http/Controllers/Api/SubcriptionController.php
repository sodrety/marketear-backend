<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Bpuig\Subby\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SubcriptionController extends Controller
{
    public function getPlans()
    {
        try {
            $plan = Plan::with('features')->get();

            return response()->json([
                'status' => true,
                'data' => $plan
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function getSubscription()
    {
        try {
            $detail = Auth::user()->subscriptions;

            return response()->json([
                'status' => true,
                'data' => $detail
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
