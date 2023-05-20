<?php

namespace App\Http\Controllers;

use App\Jobs\SrapeSource;
use App\Models\CampaignSource;
use App\Models\Creator;
use App\Models\Workspace;
use App\Models\WorkspaceCategory;
use App\Services\WorkspaceService;
use App\Models\Intent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WorkspaceController extends Controller
{
    
    protected $workspaceService;

    public function __construct(WorkspaceService $workspaceService)
    {
        $this->workspaceService = $workspaceService;
    }

    public function getWorkspace ()
    {
        if (Auth::user()->role_id == 1) {
            $data = Workspace::with('category','channels','urls','sources')->get();
        } else {
            $data = Workspace::where('user_id',Auth::user()->id)->with('category','channels','urls','sources')->get();
        }
        return response()->json($data,200);
    }

    public function getDetail ($id)
    {
        $data = Workspace::with('category','channels','urls','sources')->find($id);
        return response()->json($data,200);
    }

    public function getCreator ($username)
    {
        $data = Creator::where('username','=',$username)->first();
        return response()->json($data, 200);
    }

    public function getCategory ()
    {
        $data = WorkspaceCategory::get();
        return response()->json($data, 200);
    }

    public function create (Request $request)
    {
        $validated_array = [
            'name' => 'required',
            'type' => 'required',
            'category' => 'required|numeric',
        ];

        $validated = Validator::make($request->all(), $validated_array);
        
        if ($validated->fails()) {
            return response()->json($validated->errors(), 500);
        } else {
            try {
                $workspace = $this->workspaceService->createWorkspace($request->all(), Auth::user());

                if ($workspace && $workspace->type == 'campaign') {
                    $queue = new SrapeSource($workspace->id);
                    $this->dispatch($queue);
                }

                return response()->json([
                    'status' => true,
                    'message' => $workspace
                ], 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
    
        }
    }

    public function update (Request $request, $id)
    {
        $validated_array = [
            'name' => 'required',
            'category' => 'required|numeric',
        ];
        $validated = Validator::make($request->all(), $validated_array);
        if ($validated->fails()) {
            return response()->json($validated->errors(), 500);
        } else {
            try {
                $request['category_id'] = $request['category'];
                $workspace = Workspace::findOrFail($id);
                $workspace->update($request->all());

                return response()->json([
                    'status' => true,
                    'message' => $workspace
                ], 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
    
        }
    }

    public function updateIntent (Request $request, $id)
    {
        $validated_array = [
            'sentiment' => 'required',
        ];
        $validated = Validator::make($request->all(), $validated_array);
        if ($validated->fails()) {
            return response()->json($validated->errors(), 500);
        } else {
            try {
                $comment = Intent::find($id);
                $comment->sentiment = $request->sentiment;
                $comment->save();

                return response()->json([
                    'status' => true,
                    'message' => $comment
                ], 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
    
        }
    }

    public function deleteWorkspace ($id)
    {
        try {
            $workspace = Workspace::findOrFail($id);
            $workspace->delete();

            return response()->json([
                'status' => true,
                'message' => $workspace
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }    
 
    public function createUrl (Request $request)
    {
        $validated_array = [
            'id' => 'required',
            'type' => 'required',
            'url' => 'required'
        ];

        $validated = Validator::make($request->all(), $validated_array);
        
        if ($validated->fails()) {
            return response()->json($validated->errors(), 500);
        } else {
            try {
                $workspace = $this->workspaceService->createUrl($request->all(), $request->id);

                if ($workspace && $request->type == 'campaign') {
                    $queue = new SrapeSource($request->id);
                    $this->dispatch($queue);
                }

                return response()->json([
                    'status' => true,
                    'message' => $workspace
                ], 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
    
        }
    }

    public function reintent (Request $request)
    {
        if ($request->id) {
            $workspace = Workspace::find($request->id);
            try{
                $createUrl = $this->workspaceService->createUrl(
                    ['url' => $workspace->urls->pluck('url'),
                    'type' => $workspace->type], 
                    $request->id);
                if ($createUrl && $workspace->type == 'campaign') {
                    $queue = new SrapeSource($request->id);
                    $this->dispatch($queue);
                }
                return response()->json([
                    'status' => true,
                    'message' => $createUrl
                ], 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
        } else {
            return response()->json('no id', 500);
        }
    }

    public function recreator (Request $request)
    {
        if ($request->id) {
            try{
                $workspace = Workspace::find($request->id);
                foreach($workspace->urls as $each) {
                    if(strpos($each->url, 'tiktok')) {
                        $sourceId = explode('/', $each->url)[5];
                        $username = trim(explode('/', $each->url)[3], '@');
                        $creator = $this->workspaceService->_checkCreator($username,$each->channel_id);
                        $source = CampaignSource::where('workspace_id','=',$request->id)
                        ->where('url','=',$sourceId)->first();
                        $source->creator_id = $creator ? $creator->id : 0;
                        $source->save();
                    }
                }
                return response()->json('finish', 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
        } else {
            return response()->json('no id', 500);
        }
    }

}
