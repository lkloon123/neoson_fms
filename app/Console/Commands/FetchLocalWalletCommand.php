<?php

namespace App\Console\Commands;

use App\Cronjobs\FetchLocalWalletData;
use Illuminate\Console\Command;

class FetchLocalWalletCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:fetchlocalwallet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run fetch local wallet cron job';

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
        $this->info(DatetimePrepend::getDateTime() . 'start fetching local wallet');
        new FetchLocalWalletData();
        $this->info(DatetimePrepend::getDateTime() . 'finish fetched local wallet');
    }
}
