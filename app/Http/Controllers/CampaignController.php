<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignSource;
use App\Jobs\SrapeSource;
use App\Services\CampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index(Request $request)
    {   
        $per_page = $request->get('per_page');
        
        if (!$per_page) {
            $per_page = 15;
        }

        $data = Campaign::select('campaigns.*')->addSelect(DB::raw('(select count(id) from campaign_sources as cs where cs.campaign_id=campaigns.id) as source'))->paginate($per_page);

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

        $data = CampaignSource::where('campaign_id', $id)->get();
    
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required',
        ]);

        $campaign = CampaignService::createCampaign($request->all());
        dd($campaign);

        dispatch(new SrapeSource($campaign->id));

        return response()->json([
            'status' => true,
            'message' => "Success Create Cmapign"
        ]);
    }

    public function testScrape()
    {
        
    }
}
