<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Bpuig\Subby\Models\Plan;
use Bpuig\Subby\Models\PlanSubscription;
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
            if (isset($plan) && count($plan)) {
                $features = Auth::user()->subscription($plan[0]['tag'])->features;
                $plan[0]['features'] = $features;
            }
            return response()->json([
                'status' => true,
                'data' => isset($plan) && count($plan) ? $plan[0] : null
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function changeSubscription(Request $request)
    {
        try {
            $plan = Auth::user()->subscriptions;
            $newplan = Plan::getByTag($request->tag);
            $subscription = PlanSubscription::find($plan[0]->id);
            $subscription->changePlan($newplan);
            return response()->json([
                'status' => true,
                'data' => $subscription
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
