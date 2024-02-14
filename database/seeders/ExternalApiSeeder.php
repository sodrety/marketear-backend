<?php

namespace Database\Seeders;

use Database\Seeders\ExternalApi\ScraperApiSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExternalApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('external_apis')->truncate();
        DB::table('external_api_endpoints')->truncate();
        $this->call(ScraperApiSeeder::class);
    }
}
