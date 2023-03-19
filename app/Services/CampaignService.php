<?php 

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignSource;
use App\Models\Channel;
use App\Models\Creator;
use Illuminate\Support\Facades\DB;

class CampaignService 
{
    public function createCampaign($data)
    {
        DB::beginTransaction();
        
        $campaign = Campaign::create(['title' => $data['title']]);
        $channel = Channel::all();


        $selec = collect($channel);
        foreach($data['url'] as $url) {
            if(strpos($url, 'tiktok')) {
                $selectedChannel = $selec->filter(function($item) {
                    return $item->name == 'tiktok';
                })->first();
                $sourceId = explode('/', $url)[5];
                $username = trim(explode('/', $url)[3], '@');
                $creator = $this->_checkCreator($username, $selectedChannel->id);
            } else {
                $selectedChannel = $selec->filter(function($item) {
                    return $item->name == 'instagram';
                })->first();
                $sourceId = explode('/', $url)[2];
                // $creator = $this->_checkCreator($username, $selectedChannel->id);
                // $registerCreator = CreatorService::register($url);
            }
            
            CampaignSource::create(['full_url' => $url, 'url' => $sourceId, 'campaign_id' => $campaign->id, 'channel_id' => $selectedChannel->id, 'creator_id' => $creator->id]);
        }

        DB::commit();

        return $campaign;
    }

    public function _checkCreator($username, $channelId)
    {
        $creator = Creator::where(['username' =>  $username, 'channel_id' => $channelId])->first();
        if (!$creator) {
            $creator = TiktokService::register($username, $channelId);
        }

        return $creator;    
    }
}