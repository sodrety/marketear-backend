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
            $plan = Auth::user()->subscriptions;
            $features = Auth::user()->subscription($plan[0]['tag'])->features;
            $plan[0]['features'] = $features;
            return response()->json([
                'status' => true,
                'data' => $plan[0]
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
