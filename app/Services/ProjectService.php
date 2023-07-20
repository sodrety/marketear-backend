<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\ProjectUrl;
use App\Models\Channel;
use App\Models\CampaignSource;
use App\Models\Creator;

class ProjectService
{
    public function createProject($data, $user)
    {
        try {
            DB::beginTransaction();
                $project = Project::create([
                    'name' => $data['name'],
                    'type' => $data['type'],
                    'category_id' => $data['category'],
                    'user_id' => $user->id
                ]);

                if ($project) {
                    $this->createUrl($data, $project->id);
                }
            DB::commit();

            return $project;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createUrl($data, $id = null)
    {
        if ($id) {
            try {
                DB::beginTransaction();
                
                $channel = Channel::all();
                $creator = null;
                
                $selec = collect($channel);
                foreach($data['url'] as $url) {
                    if (isset($url) && (strpos($url, 'tiktok') || strpos($url, 'instagram'))) {
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
                        
                        $projecturl = ProjectUrl::where('url',$url)->where('project_id', $id)->first();
                        if (!$projecturl) {
                            ProjectUrl::create([
                                'url' => $url, 
                                'project_id' => $id, 
                                'channel_id' => $selectedChannel->id]);
                        }
                        if ($data['type'] == 'campaign') {
                            $source = CampaignSource::where('url',$sourceId)->where('project_id', $id)->first();
                            if (!$source) {
                                CampaignSource::create(['url' => $sourceId, 'project_id' => $id, 'channel_id' => $selectedChannel->id, 'creator_id' => ($creator ? $creator->id : 0)]);
                            }
                        }
                    }
                }

                DB::commit();
                return true;
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return false;
        }
    }

    public function _checkCreator($username, $channelId)
    {
        $creator = Creator::where(['username' =>  $username, 'channel_id' => $channelId])->first();
        if (!$creator) {
            $creator = $channelId == 1 ? TiktokService::register($username, $channelId) : InstagramService::register($username, $channelId);
        }

        return $creator;    
    }
}
