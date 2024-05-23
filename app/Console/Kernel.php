<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        'App\Console\Commands\CreatePemasukan',
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:create-pemasukan')->daily()->timezone('Asia/Makassar');
        $schedule->command('app:tarik-saldo-digital')->monthly()->timezone('Asia/Makassar');
        // $schedule->command('app:create-pemasukan')->everyMinute();
        // $schedule->command('app:tarik-saldo-digital')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
