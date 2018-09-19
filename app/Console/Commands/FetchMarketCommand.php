<?php

namespace App\Console\Commands;

use App\Cronjobs\FetchMarketData;
use Illuminate\Console\Command;

class FetchMarketCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:fetchmarket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run fetch market cron job';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info(DatetimePrepend::getDateTime() . 'start fetching market data');
        new FetchMarketData();
        $this->info(DatetimePrepend::getDateTime() . 'finish fetched market data');
    }
}
