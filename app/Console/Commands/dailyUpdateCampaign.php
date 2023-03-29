<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        
    }
}
