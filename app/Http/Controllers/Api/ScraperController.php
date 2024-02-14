<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExternalApis;
use App\Models\User;
use App\Services\TokenService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ScraperController extends Controller
{

    private $domain;
    private $tokenService;
    function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
        $this->domain = ExternalApis::where(['category' => 'external', 'provider' => 'scraper'])->first();
    }
    public function generateToken()
    {
        $apiProp = $this->domain->endpoints()->where('name', 'generate-token')->first();
        if (!$apiProp) {
            return false;
        }

        $response = $this->hitApi($this->domain->base_url, $apiProp->endpoint, [], 'post', ['email' => 'root@crawler.marketear.co', 'password' => 'm@rk3te4rR4nzz@$@$']);
        if (!$response['status']) {
            Log::error("somethionsda");
        } 
        Cache::put('scraper_token', $response['data']->data->access_token, now()->addMinutes(58));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $token = $this->tokenService->checkToken(Auth::user()->id);
        if ($token <= 0) {
            return response()->json([
                'status' => false,
                'message' => "Unsufficient Token"
            ]);
        }
        
        $apiProp = $this->domain->endpoints()->where('name', 'search-merchant')->first();
        if (!$apiProp) {
            return false;
        }

        if (!Cache::has('scraper_token')) {
            $this->generateToken();
        }
        try {
            $token = Cache::get('scraper_token');
            $response = $this->hitApi($this->domain->base_url, $apiProp->endpoint, ['Authorization' => "Bearer {$token}"], 'get', ['search' => $keyword, 'marketplace_id' => 1]);
        } catch (Exception $e){
            return json_encode($e);
        }

        $this->tokenService->minusToken(Auth::user()->id);

        return response()->json($response);
    }

    public function searchProduct(Request $request)
    {
        $keyword = $request->keyword;

        $token = $this->tokenService->checkToken(Auth::user()->id);
        if ($token <= 0) {
            return response()->json([
                'status' => false,
                'message' => "Unsufficient Token"
            ]);
        }
        
        $apiProp = $this->domain->endpoints()->where('name', 'search-product-shopee')->first();
        if (!$apiProp) {
            return false;
        }

        if (!Cache::has('scraper_token')) {
            $this->generateToken();
        }
        try {
            $token = Cache::get('scraper_token');
            $response = $this->hitApi($this->domain->base_url, $apiProp->endpoint, ['Authorization' => "Bearer {$token}"], 'get', ['keyword' => $keyword, 'marketplace_id' => 1]);
        } catch (Exception $e){
            return json_encode($e);
        }

        $this->tokenService->minusToken(Auth::user()->id);
        
        return response()->json($response);
    }

    public function topupDummy()
    {
        $user_id = Auth::user()->id;

        $user = User::find($user_id);
        $user->token = $user->token + 100;
        $user->save();
        
        return response()->json([
            'status' => true,
            'message' => "Success topup token"
        ]);
    }
}
