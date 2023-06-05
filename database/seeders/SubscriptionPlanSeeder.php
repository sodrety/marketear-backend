<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bpuig\Subby\Models\Plan;
use Bpuig\Subby\Models\PlanFeature;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plansType = [
            [
                'tag' => 'free',
                'name' => 'Free',
                'description' => 'Basic',
                'price' => 0,
                'workspace' => 1,
                'url' => 1,
                'comment' => 100
            ],
            [
                'tag' => 'tier-1',
                'name' => 'Tier 1',
                'description' => 'Personal',
                'price' => 100000,
                'workspace' => 1,
                'url' => 3,
                'comment' => 300
            ],
            [
                'tag' => 'tier-2',
                'name' => 'Tier 2',
                'description' => '⭐ Startup',
                'price' => 300000,
                'workspace' => 3,
                'url' => 5,
                'comment' => 1000
            ],
            [
                'tag' => 'tier-3',
                'name' => 'Tier 3',
                'description' => 'Enterprise',
                'price' => 999999,
                'workspace' => 999999,
                'url' => 999999,
                'comment' => 9999999
            ]
        ];

        foreach($plansType as $item) {
            $plan = Plan::create([
                'tag' => $item['tag'],
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'signup_fee' => $item['price'],
                'invoice_period' => 1,
                'invoice_interval' => 'month',
                'trial_period' => 15,
                'trial_interval' => 'day',
                'grace_period' => 1,
                'grace_interval' => 'day',
                'tier' => 1,
                'currency' => 'IDR',
            ]);

            $plan->features()->saveMany([
                new PlanFeature(['tag' => 'workspace_number', 'name' => 'Workspace', 'value' => $item['workspace'], 'sort_order' => 1]),
                new PlanFeature(['tag' => 'url_campaign_number', 'name' => 'URL Campaign', 'value' => $item['url'], 'sort_order' => 10]),
                new PlanFeature(['tag' => 'comment_number', 'name' => 'Comment Crawl', 'value' => $item['comment'], 'sort_order' => 15])
            ]);
        }
    }
}
