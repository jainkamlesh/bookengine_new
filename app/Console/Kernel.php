<?php

namespace App\Console;

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
        Commands\SendBooking::class,
        Commands\MakeGoogleHotelXML::class,
        Commands\ARIUpdateGoogle::class,
        Commands\UpdateRoomsToGoogle::class,
        Commands\RemoveARI::class,
        Commands\CheckGooglePendingARI::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:booking')->everyMinute();
        $schedule->command('build:googlexml')->weekly();
        $schedule->command('update:google')->everyMinute();
        $schedule->command('updateroom:google')->everyMinute();
        $schedule->command('remove:ari')->weekly();
        $schedule->command('google:pendingari')->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
