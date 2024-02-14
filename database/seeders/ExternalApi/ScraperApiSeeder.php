<?php

namespace Database\Seeders\ExternalApi;

use App\Models\ExternalApis;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScraperApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $external = new ExternalApis();
            $external->category = 'external';
            $external->provider = 'scraper';
            $external->base_url = 'http://34.128.78.223/api/';
            $external->save();
            DB::table('external_api_endpoints')->insert([
                [
                    'external_api_id' => $external->id,
                    'name' => 'generate-token',
                    'endpoint' => 'auth/login',
                    'method' => 'post',
                    'description' => 'Generate Token',
                ],
                [
                    'external_api_id' => $external->id,
                    'name' => 'search-merchant',
                    'endpoint' => 'merchant/search-marketplace',
                    'method' => 'get',
                    'description' => 'Search Merchant',
                ],
                [
                    'external_api_id' => $external->id,
                    'name' => 'register-merchant',
                    'endpoint' => 'merchant/search-marketplace',
                    'method' => 'post',
                    'description' => 'Register Merchant',
                ],
                [
                    'external_api_id' => $external->id,
                    'name' => 'get-merchant',
                    'endpoint' => 'merchant',
                    'method' => 'get',
                    'description' => 'Get Merchant',
                ],
                [
                    'external_api_id' => $external->id,
                    'name' => 'search-product-shopee',
                    'endpoint' => 'search-product/shopee/search',
                    'method' => 'get',
                    'description' => 'Search product shopee',
                ],
            ]);
        } catch (Exception $e) {
            Log::error(json_encode($e));
        }
    }
}
