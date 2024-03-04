<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RateRestrictionMaster;
use App\Models\InventoryMaster;
use Illuminate\Support\Facades\Log;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\Logs;

class RemoveARI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:ari';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Availability and rate past dates data';

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
     * @return int
     */
    public function handle()
    {
        Log::info('Call Remove ARI');

        $rome = new DateTimeZone('Europe/Rome');
        $date = new DateTime();
        $date->modify('-10 days');

        $date->setTimezone($rome);
        $before_10_days_date = $date->format('Y-m-d');
        Log::info( $before_10_days_date );

        ##remove inventory past dates
        InventoryMaster::where('date', '<', $before_10_days_date)->delete();

        ##remove rate & restriction past dates
        RateRestrictionMaster::where('date', '<', $before_10_days_date)->delete();

        ##remove logs past dates
        Logs::where('date', '<', $before_10_days_date)->delete();
    }
}
