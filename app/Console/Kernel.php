<?php

namespace App\Console;

use App\Console\Commands\CheckMinerStatusCommand;
use App\Console\Commands\FetchLocalWalletCommand;
use App\Console\Commands\FetchMarketCommand;
use App\Console\Commands\FetchNicehashAlgoDataCommand;
use App\Console\Commands\FetchNicehashStatusCommand;
use App\Console\Commands\FetchPoolCommand;
use App\Console\Commands\TruncateMinerSummariesCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        FetchPoolCommand::class,
        FetchMarketCommand::class,
        FetchLocalWalletCommand::class,
        FetchNicehashAlgoDataCommand::class,
        FetchNicehashStatusCommand::class,
        TruncateMinerSummariesCommand::class,
        CheckMinerStatusCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(FetchPoolCommand::class)->timezone('Asia/Kuala_Lumpur')->everyFifteenMinutes()->appendOutputTo(storage_path('logs/cron.log'));
        $schedule->command(FetchMarketCommand::class)->timezone('Asia/Kuala_Lumpur')->everyFifteenMinutes()->appendOutputTo(storage_path('logs/cron.log'));
        $schedule->command(FetchLocalWalletCommand::class)->timezone('Asia/Kuala_Lumpur')->everyFiveMinutes()->appendOutputTo(storage_path('logs/cron.log'));
        $schedule->command(FetchNicehashAlgoDataCommand::class)->timezone('Asia/Kuala_Lumpur')->daily()->appendOutputTo(storage_path('logs/cron.log'));
        $schedule->command(FetchNicehashStatusCommand::class)->timezone('Asia/Kuala_Lumpur')->everyFiveMinutes()->appendOutputTo(storage_path('logs/cron.log'));
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
