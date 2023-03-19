<?php 

namespace App\Services;

use App\Models\CampaignSource;
use App\Models\Creator;
use App\Models\Intent;
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

            return $sour;
        }

        $data = $this->_postDetail($data);

        if (!$data) {
            return false;
        }
        $target = 10;
        $per_page = 10;
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
                    $intent = Intent::create(
                        [
                            'campaign_source_id' => $data['id'], 
                            'nickname' => $c->user->nickname, 
                            'region' => $c->user->region,
                            'language' => $c->user->language,
                            'picture' => $c->user->avatar_thumb->url_list[0],
                            'text' => $c->text,
                            'cid' => $c->cid,
                            'comment_at' => date('Y/m/d H:i:s', $c->create_time)
                        ]
                    );
                    $result[] = [
                        'text' => $c->text,
                        'id' => $intent->id
                    ];
                }
                $cursor+= $per_page;
            }
        } catch (Exception $e) {
            LogService::record([
                'request' => "",
                'response' => json_encode($e),
                'url' => "https://scraptik.p.rapidapi.com/list-comments?aweme_id=".$data['url']."&count=$per_page&cursor=$cursor",
            ]);
            return false;
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
        
        $source = CampaignSource::where('id', $data['id'])->first();
        $source->comment_count = $res->aweme_detail->statistics->comment_count;
        $source->collect_count = $res->aweme_detail->statistics->collect_count;
        $source->like_count = $res->aweme_detail->statistics->digg_count;
        $source->play_count = $res->aweme_detail->statistics->play_count;
        $source->share_count = $res->aweme_detail->statistics->share_count;
        $source->other_share_count = json_encode((object)[
                                        'whatsapp_share_count' => $res->aweme_detail->statistics->whatsapp_share_count
        ]);
        $source->caption = $res->aweme_detail->desc;
        $source->thumbnail = $res->aweme_detail->video->cover->url_list[0];
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
            return response()->json([
                'status' => false,
            ]);
        }
        $res = json_decode($response);
        // dd($res->userInfo);
        $creator = Creator::create([
            'name' => $res->userInfo->user->nickname,
            'username' => $res->userInfo->user->uniqueId,
            'signature' => $res->userInfo->user->signature,
            'stats' => json_encode($res->userInfo->stats),
            'channel_id' => $channelId
        ]);
        
        return $creator;
    }
}