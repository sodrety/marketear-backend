<?php

namespace App\Console\Commands;

use App\Models\CampaignSource;
use App\Models\CampaignSourceHistory;
use App\Services\LogService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class dailyUpdateCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:daily-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Update 7 days forward';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("start daily getter");
        
        $data = CampaignSource::with('history')->where("history", "<", 7)->get();
        Log::info("data =>".json_encode($data));

        foreach($data as $d) {
            $url = "https://scraptik.p.rapidapi.com/get-post?aweme_id=".$d->url;
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
            }
            $res = json_decode($response);

            $dataUpdate = [
                "comment_count" => $res->aweme_detail->statistics->comment_count,
                "collect_count" => $res->aweme_detail->statistics->collect_count,
                "like_count" => $res->aweme_detail->statistics->digg_count,
                "play_count" => $res->aweme_detail->statistics->play_count,
                "share_count" => $res->aweme_detail->statistics->share_count,
                "other_share_count" => json_encode((object)[
                                                'whatsapp_share_count' => $res->aweme_detail->statistics->whatsapp_share_count
                ]),
                "caption" => $res->aweme_detail->desc,
                "thumbnail" => $res->aweme_detail->video->cover->url_list[0]
            ];

            // UPDATE NEWEST DATA
            $dataUpdate['history'] = $d->history + 1;
            CampaignSource::find($d->id)->update($dataUpdate);
            unset($dataUpdate['history']);
            
            // RECORD HISTORY CAMPAIGN
            $dataUpdate['campaign_source_id'] = $d->id;
            CampaignSourceHistory::create($dataUpdate);
            unset($dataUpdate['campaign_source_id']);

        }
        
        Log::info("daily getter done");
    }
}
