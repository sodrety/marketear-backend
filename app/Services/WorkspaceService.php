<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Workspace;
use App\Models\WorkspaceUrl;
use App\Models\Channel;
use App\Models\CampaignSource;
use App\Models\Creator;
use Auth;

class WorkspaceService
{
    public function createWorkspace($data)
    {
        try {
            DB::beginTransaction();
                $workspace = Workspace::create([
                    'name' => $data['name'],
                    'type' => $data['type'],
                    'category_id' => $data['category'],
                    'user_id' => Auth::user()->id
                ]);

                if ($workspace) {
                    $this->createUrl($data, $workspace->id);
                }
            DB::commit();

            return $workspace;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createUrl($data, $id = null)
    {
        if ($id) {
            DB::beginTransaction();
            
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
                if (isset($url->id)) {
                    WorkspaceUrl::find($url->id);
                } else {
                    WorkspaceUrl::create([
                        'url' => $url, 
                        'workspace_id' => $id, 
                        'channel_id' => $selectedChannel->id]);
                }
                if ($data['type'] == 'campaign') {
                    $source = CampaignSource::where('url',$sourceId)->where('workspace_id', $id)->first();
                    if (!$source) {
                        CampaignSource::create(['url' => $sourceId, 'workspace_id' => $id, 'channel_id' => $selectedChannel->id, 'creator_id' => $creator ? $creator->id : 0]);
                    }
                }
            }

            DB::commit();
            return true;
        } else {
            return false;
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
