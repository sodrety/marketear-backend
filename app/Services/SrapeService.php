<?php

namespace App\Services;

use App\Models\CampaignSource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SrapeService 
{

    protected $tiktokService;
    public function __construct(TiktokService $tiktokService)
    {
        $this->tiktokService = $tiktokService;
    }
    public function scrape($workspaceId = 79)
    {
        // $source = CampaignSource::where("campaign_id", $campaignId)->with('channel')->get();
        $source = CampaignSource::where("workspace_id", $workspaceId)->with('channel')->get();
        if (count($source) < 1) {
            return Log::info("Theres no url to scrape");
        }
        $intent = [];
        $response = [];
        foreach($source as $url) {
            // switch($url->channel->name) {
            //     case 'tiktok':
            if ($url->channel->name == 'tiktok') $response = $this->tiktokService->tiktokScrape($url);
                // break;
                // case 'instagram':
                //     $response = $this->tiktokService->tiktokScrape($url);
                // break;
            // }
            if (is_array($response) && count($response)) $intent = array_merge($intent, $response);
        }
        
        if(!$intent || (is_array($intent) && count($intent) < 1)) {
            return response()->json([
                'status' => false,
            ], 500);
        }

        // $predict = Http::post(env("ML_URL", 'http://localhost:5000')."/api/predict", $intent);

        // if ($predict->failed() || $predict->clientError() || $predict->serverError()) {
        //     $predict->throw()->json();
        // }

        return response()->json([
            'status' => true,
        ], 200);

        
    }
}