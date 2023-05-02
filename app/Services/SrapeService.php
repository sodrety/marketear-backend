<?php

namespace App\Services;

use App\Models\CampaignSource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SrapeService
{

    protected $tiktokService;
    public function __construct(TiktokService $tiktokService)
    {
        $this->tiktokService = $tiktokService;
    }
    public function scrape($campaignId = 51)
    {   
        Log::debug("campaign id => ".json_encode($campaignId));
        $source = CampaignSource::where('campaign_id', $campaignId)->get();
        // dd($source);
        // $source = DB::table('campaign_sources')->all();
        // return Log::debug("campaign => ".json_encode($source));
        if (count($source) < 1) {
            return Log::info("Theres no url to scrape");
        }
        $intent = [];
        foreach($source as $url) {
            switch($url->channel->name) {
                case 'tiktok':
                    $response = $this->tiktokService->tiktokScrape($url);
                break;
                case 'instagram':
                    $response = $this->tiktokService->tiktokScrape($url);
                break;
            }
            $intent = array_merge($intent, $response);
        }
        
        if(!$response || (is_array($response) && count($response) < 1)) {
            return response()->json([
                'status' => false,
            ]);
        }
        Log::debug("data predict => ".json_encode($intent));
        $predict = Http::post(env("ML_URL", 'http://127.0.0.1:5000')."/api/predict", $intent);

        if ($predict->failed() || $predict->clientError() || $predict->serverError()) {
            $predict->throw()->json();
        }

        return response()->json([
            'status' => true,
        ]);

        
    }
}