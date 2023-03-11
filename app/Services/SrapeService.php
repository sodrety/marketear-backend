<?php

namespace App\Services;

use App\Models\CampaignSource;
use Illuminate\Support\Facades\Log;

class SrapeService 
{

    protected $tiktokService;
    public function __construct(TiktokService $tiktokService)
    {
        $this->tiktokService = $tiktokService;
    }
    public function scrape($campaignId = 44)
    {
        $source = CampaignSource::where("campaign_id", $campaignId)->with('channel')->get();

        if (count($source) < 1) {
            return Log::info("Theres no url to scrape");
        }
        
        foreach($source as $url) {
            switch($url->channel->name) {
                case 'tiktok':
                    $response = $this->tiktokService->tiktokScrape($url);
                break;
                case 'instagram':
                    $response = $this->tiktokService->tiktokScrape($url);
                break;
            }
        }
        
    }
}