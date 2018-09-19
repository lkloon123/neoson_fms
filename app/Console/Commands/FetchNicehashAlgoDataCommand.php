<?php

namespace App\Console\Commands;

use App\Cronjobs\FetchNicehashAlgoData;
use Illuminate\Console\Command;

class FetchNicehashAlgoDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:fetchNicehashAlgo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run fetch nicehash algo cron job';

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
        $this->info(DatetimePrepend::getDateTime() . 'start fetching nicehash algo data');
        new FetchNicehashAlgoData();
        $this->info(DatetimePrepend::getDateTime() . 'finish fetched nicehash algo data');
    }
}
