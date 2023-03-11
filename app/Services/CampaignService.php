<?php 

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignSource;
use App\Models\Channel;
use Illuminate\Support\Facades\DB;

class CampaignService 
{
    static public function createCampaign($data)
    {
        DB::beginTransaction();
        $campaign = Campaign::create(['title' => $data['title']]);
        $channel = Channel::all();
        $selec = collect($channel);
        foreach($data['url'] as $url) {
            
            if(strpos($url, 'tiktok')) {
                $selec = $selec->filter(function($item) {
                    return $item->name == 'tiktok';
                })->first();
                $sourceId = explode('/', $url)[5];
            } else {
                $selec = $selec->filter(function($item) {
                    return $item->name == 'instagram';
                })->first();
                $sourceId = explode('/', $url)[2];
            }
            
            CampaignSource::create(['url' => $sourceId, 'campaign_id' => $campaign->id, 'channel_id' => $selec->id]);
        }

        DB::commit();

        return $campaign;
    }
}