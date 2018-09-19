<?php

namespace App\Console\Commands;

use App\Cronjobs\CheckMinerStatus;
use App\Cronjobs\FetchPoolData;
use Illuminate\Console\Command;

class CheckMinerStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:checkMinerStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run check miner status cron job';

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
        $this->info(DatetimePrepend::getDateTime() . 'start check miner status');
        new CheckMinerStatus();
        $this->info(DatetimePrepend::getDateTime() . 'finish check miner status');
    }
}
