<?php

namespace App\Console\Commands;

use App\Cronjobs\FetchNicehashAlgoData;
use App\Cronjobs\FetchNicehashStatusData;
use Illuminate\Console\Command;

class FetchNicehashStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:fetchNicehashStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run fetch nicehash status cron job';

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
        $this->info(DatetimePrepend::getDateTime() . 'start fetching nicehash status');
        new FetchNicehashStatusData();
        $this->info(DatetimePrepend::getDateTime() . 'finish fetched nicehash status');
    }
}
