<?php

namespace App\Console;

use Clockwork\Request\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
//         $schedule->command('inspire')->hourly();
        $schedule->call(function () {

           \Illuminate\Support\Facades\Log::info(DB::table('users')
                ->where('otp_attempt_count', '>=', 3)
                ->whereDate('latest_otp_attempt', now()->subDay())
               ->update(['otp_attempt_count' => 0])

           );

        })->daily();
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
