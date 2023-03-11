<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->truncate();
        try {
            DB::table('channels')->insert([
                [
                    'name' => 'tiktok',
                    'icon' => 'aaa',
                ],
                [
                    'name' => 'instagram',
                    'icon' => 'aaa',
                ]
            ]);
        } catch (Exception $e) {
            Log::error(json_encode($e));
        }
    }
}
