<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignSource;
use App\Jobs\SrapeSource;
use App\Models\Intent;
use App\Services\CampaignService;
use App\Services\CreatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    protected $campaignService;
    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }
    public function index(Request $request)
    {   
        $per_page = $request->get('per_page');
        
        if (!$per_page) {
            $per_page = 15;
        }

        $data = Campaign::select('campaigns.*')->addSelect(DB::raw('(select count(id) from campaign_sources as cs where cs.campaign_id=campaigns.id) as source'))->simplePaginate($per_page);

        return $data;
        // return response()->json([
        //     'status' => true,
        //     'data' => $data,
        // ]);
    }
    
    public function detail(Request $request, $id)
    {
        $per_page = $request->get('per_page');
        
        if (!$per_page) {
            $per_page = 15;
        }

        $data = CampaignSource::where('campaign_id', $id)
                ->leftJoin('creators as c', 'c.id', '=', 'campaign_sources.creator_id')
                ->simplePaginate($per_page);
    
        return $data;
        // return response()->json([
        //     'status' => true,
        //     'data' => $data,
        // ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required',
        ]);
        
        // Create campaign
        $campaign = $this->campaignService->createCampaign($request->all());

        //dispatch job to scrape comments
        $queue = new SrapeSource($campaign->id);
        $this->dispatch($queue);
        // dispatch(new SrapeSource($campaign->id));

        return response()->json([
            'status' => true,
            'message' => "Success Create Cmapign"
        ]);
    }

    public function intent(Request $request, $id)
    {
        $data = CampaignSource::join('intents as i', function($q) use($id) {
            $q->on('i.campaign_source_id', '=', 'campaign_sources.id')
            ->where('campaign_id', $id);
        })
        ->simplePaginate(10);

        return $data;
        // return response()->json([
        //     'status' => true,
        //     'data' => $data,
        // ]);
    }

    public function report($id)
    {
        $data = CampaignSource::where('campaign_id', $id)->get();

        if(count($data) == 0) {
            return response()->json([
                'status' => false,
            ]);
        }

        $collection = collect($data);

        $total = $collection->map(function($t){
            return [
                'total_comments' => $t->comment_count,
                'total_views' => $t->collect_count,
                'total_likes' => $t->like_count,
                'total_shares' => $t->share_count,
                'total_plays' => $t->play_count,
            ];
        });

        $subtotal = [
            'comments' => $total->sum('total_comments'),
            'views' => $total->sum('total_views'),
            'likes' => $total->sum('total_likes'),
            'shares' => $total->sum('total_shares'),
            'plays' => $total->sum('total_plays'),
        ];

        $most = $collection->sortByDesc('comment_count')->values()->first();

        $intent = Intent::join('campaign_sources as cs', 'cs.id', '=', 'intents.campaign_source_id')
        ->where('cs.campaign_id', $id)
        ->limit(15)->get();

        $result = [
            'total' => $subtotal,
            'most' => $most,
            'intent' => $intent
        ];

        return $result;

    }
}
