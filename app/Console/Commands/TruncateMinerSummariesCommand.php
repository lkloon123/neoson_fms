<?php

namespace App\Console\Commands;

use App\Cronjobs\TruncateMinerSummaries;
use Illuminate\Console\Command;

class TruncateMinerSummariesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:truncateMinerSummary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run truncate miner summary cron job';

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
        $this->info(DatetimePrepend::getDateTime() . 'start truncate miner summary');
        new TruncateMinerSummaries();
        $this->info(DatetimePrepend::getDateTime() . 'finish truncate miner summary');
    }
}
