<?php 

namespace App\Services;

use App\Models\CampaignSource;
use App\Models\Creator;
use App\Models\Intent;
use Illuminate\Support\Facades\Log;
use Exception;

class TiktokService 
{
    public function tiktokScrape($data)
    {
        // $post = CampaignSource::where('url', $data['url'])->first();
        if($data['is_scraped'] == 1) {
            $sour = Intent::where('campaign_source_id', $data['id'])->whereNull('sentiment')->get()->map(function($q) {
                return [
                    'text' => $q->text,
                    'id' => $q->id
                ];
            })
            ->toArray();
            
            Log::info($data);
            return $sour;
        }

        $data = $this->_postDetail($data);

        if (!$data) {
            return false;
        }
        $target = 10;
        $per_page = 30;
        $cursor = 0;
        $result = [];
        try {
            while($cursor < $target) {
                $url = "https://scraptik.p.rapidapi.com/list-comments?aweme_id=".$data['url']."&count=$per_page&cursor=$cursor";

                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "X-RapidAPI-Host: scraptik.p.rapidapi.com",
                        "X-RapidAPI-Key: e68889ced6mshe37b36ac3d0e7b5p1aea70jsn667cfdcfb1b4"
                    ],
                ]);
        
                $response = curl_exec($curl);
                $err = curl_error($curl);
        
                curl_close($curl);
        
                if ($err) {
                    LogService::record([
                        'request' => "",
                        'response' => json_encode($err),
                        'url' => $url,
                    ]);
                    return false;
                }
                if(!$response) {
                    return false;
                }

                $comments = json_decode($response);

                foreach($comments->comments as $c) {
                    if (isset($c->user)) {
                        $intent = Intent::create(
                            [
                                'campaign_source_id' => $data['id'], 
                                'nickname' => $c->user->nickname, 
                                'region' => $c->user->region,
                                'language' => $c->user->language,
                                'picture' => $c->user->avatar_thumb->url_list[0],
                                'text' => substr($c->text,0,254),
                                'cid' => $c->cid,
                                'sentiment' => 'Neutral',
                                'score' => 0,
                                'comment_at' => date('Y/m/d H:i:s', $c->create_time)
                            ]
                        );
                        array_push($result,[
                            'text' => $c->text,
                            'id' => $intent->id
                        ]);
                    }
                }
                $cursor+= $per_page;
            }
        } catch (Exception $e) {
            LogService::record([
                'request' => "",
                'response' => json_encode($e),
                'url' => "https://scraptik.p.rapidapi.com/list-comments?aweme_id=".$data['url']."&count=$per_page&cursor=$cursor",
            ]);
            return [];
        }

        // UPDATE CAMPAIGN SOURCE ID
        CampaignSource::where('id', $data['id'])->update(['is_scraped' => 1]);

        return $result;

    }

    private function _postDetail($data)
    {
        $url = "https://scraptik.p.rapidapi.com/get-post?aweme_id=".$data['url'];
        try {
            $curl = curl_init();
    
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-RapidAPI-Host: scraptik.p.rapidapi.com",
                    "X-RapidAPI-Key: e68889ced6mshe37b36ac3d0e7b5p1aea70jsn667cfdcfb1b4"
                ],
            ]);
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
            Log::info($url);
            if ($err) {
                LogService::record([
                    'request' => "",
                    'response' => json_encode($err),
                    'url' => $url,
                ]);
                return false;
            }
        } catch (Exception $e) {
            LogService::record([
                'request' => "",
                'response' => json_encode($e),
                'url' => $url,
            ]);
            return false;
        }

        if (!$response) {
            return false;
            // // return response()->json([
            //     'status' => false,
            // ]);
        }
        $res = json_decode($response);
        
        Log::info($response);
        $source = CampaignSource::where('id', $data['id'])->first();
        if (isset($res->aweme_detail)) {
            $source->comment_count = $res->aweme_detail->statistics->comment_count;
            $source->collect_count = $res->aweme_detail->statistics->collect_count;
            $source->like_count = $res->aweme_detail->statistics->digg_count;
            $source->play_count = $res->aweme_detail->statistics->play_count;
            $source->share_count = $res->aweme_detail->statistics->share_count;
            $source->other_share_count = json_encode((object)[
                                            'whatsapp_share_count' => $res->aweme_detail->statistics->whatsapp_share_count
            ]);
            $source->caption = substr($res->aweme_detail->desc, 0, 254);
            $source->thumbnail = $res->aweme_detail->video->cover->url_list[0];
            $source->created_at = \Carbon\Carbon::parse($res->aweme_detail->create_time);
        }
        $source->save();
                    
        return $source;
        
    }

    static public function register($username, $channelId)
    {
        try {

            $curl = curl_init();
    
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://scraptik.p.rapidapi.com/web/get-user?username=$username",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-RapidAPI-Host: scraptik.p.rapidapi.com",
                    "X-RapidAPI-Key: e68889ced6mshe37b36ac3d0e7b5p1aea70jsn667cfdcfb1b4"
                ],
            ]);
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
            if ($err) {
                LogService::record([
                    'request' => "",
                    'response' => json_encode($err),
                    'url' => "https://scraptik.p.rapidapi.com/web/get-user?username=$username",
                ]);
            }
        } catch (Exception $e) {
            LogService::record([
                'request' => "",
                'response' => json_encode($e),
                'url' => "https://scraptik.p.rapidapi.com/web/get-user?username=$username",
            ]);
        }


        if (!$response) {
            return false;
        }
        $res = json_decode($response);
        // dd($res->userInfo);
        if (isset($res->userInfo) && isset($res->userInfo->user->nickname)) {
            $creator = Creator::create([
                'name' => $res->userInfo->user->nickname,
                'username' => $res->userInfo->user->uniqueId,
                'thumbnail' => $res->userInfo->user->avatarThumb,
                'signature' => $res->userInfo->user->signature,
                'stats' => json_encode($res->userInfo->stats),
                'channel_id' => $channelId
            ]);
            
            return $creator;
        } else {
            return false;
        }
    }
}