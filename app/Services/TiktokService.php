<?php 

namespace App\Services;

use App\Models\Intent;
use Exception;

class TiktokService 
{
    public function tiktokScrape($data)
    {
        $post = $this->_postDetail($data);
        $curl = curl_init();
        $url = "https://scraptik.p.rapidapi.com/list-comments?aweme_id=".$data['url']."&count=50&cursor=0";
        try {
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
                    "X-RapidAPI-Key: 3405dc4508msh2417370f3eec1f4p15f444jsn30a3527c24bf"
                ],
            ]);
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
            if ($err) {
                echo "cURL Error #:" . $err;
            }
        } catch (Exception $e) {
            echo $e;
        }

        if (!$response) {
            return response()->json([
                'status' => false,
            ]);
        }

        $comments = json_decode($response);
        foreach($comments->comments as $c) {
            Intent::create(
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
          }
    }

    private function _postDetail($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://scraptik.p.rapidapi.com/get-post?aweme_id=".$data['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: scraptik.p.rapidapi.com",
                "X-RapidAPI-Key: 3405dc4508msh2417370f3eec1f4p15f444jsn30a3527c24bf"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
        
    }
}