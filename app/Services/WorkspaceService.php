<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Workspace;
use App\Models\WorkspaceUrl;
use App\Models\Channel;
use App\Models\CampaignSource;
use App\Models\Creator;

class WorkspaceService
{
    public function createWorkspace($data)
    {
        try {
            DB::beginTransaction();
                $workspace = Workspace::create([
                    'name' => $data['name'],
                    'type' => $data['type'],
                    'category_id' => $data['category']
                ]);

                if ($workspace) {
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
                            $sourceId = explode('/', $url)[4];
                        }
                        
                        WorkspaceUrl::create(['url' => $url, 'workspace_id' => $workspace->id, 'channel_id' => $selectedChannel->id]);

                        if ($data['type'] == 'campaign') {
                            CampaignSource::create(['url' => $sourceId, 'workspace_id' => $workspace->id, 'channel_id' => $selectedChannel->id, 'creator_id' => $creator ? $creator->id : 0]);
                        }
                    }
                }
            DB::commit();

            return $workspace;
        } catch (\Throwable $th) {
            throw $th;
        }
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
