<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Storage;
use Mail;

class CheckGooglePendingARI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:pendingari';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Google pending ARI file before 10 mins exists';

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
        Log::info('Call Check Google ARI');

        // $rome = new DateTimeZone('Asia/Kolkata');
        $date = new DateTime();
        // $date->setTimezone($rome);
        $current_time = $date->format('Y-m-d H:i:s');
        
        ##check availability
        $path = storage_path('app/public/Availability');
        $files = File::files($path);

        $inventory_pending_file = 0;
        $rate_pending_file      = 0;
        $rateplan_pending_file  = 0;

        ##check inventory        
        foreach ($files as $key => $file) {
            $file_time = date("Y-m-d H:i:s.", filectime($file));

            $startTime  = Carbon::parse($current_time);
            $finishTime = Carbon::parse($file_time);

            $totalDuration = $finishTime->diffInMinutes($startTime);

            if ( $totalDuration > 10 ) {
                $inventory_pending_file = 1;
            }
        }

        ##check rate
        $path = storage_path('app/public/Rate');
        $files = File::files($path);

        foreach ($files as $key => $file) {
            $file_time = date("Y-m-d H:i:s.", filectime($file));

            $startTime = Carbon::parse($current_time);
            $finishTime = Carbon::parse($file_time);

            $totalDuration = $finishTime->diffInMinutes($startTime);

            if ( $totalDuration > 10 ) {
                $rate_pending_file = 1;
            }
        }

        ##check rateplan
        $path = storage_path('app/public/RatePlan');
        $files = File::files($path);

        foreach ($files as $key => $file) {
            $file_time = date("Y-m-d H:i:s.", filectime($file));

            $startTime = Carbon::parse($current_time);
            $finishTime = Carbon::parse($file_time);

            $totalDuration = $finishTime->diffInMinutes($startTime);

            if ( $totalDuration > 10 ) {
                $rateplan_pending_file = 1;
            }
        }

        if ( $inventory_pending_file || $rate_pending_file || $rateplan_pending_file ) {
            $data = array();
            $email = 'shyarakishor@gmail.com';
            try {
                Mail::send('google_pending_ari_mail',$data,function($message) use ( $email ){
                    $message->from('account@persefone.it');
                    $message->to('shyarakishor@gmail.com', 'info@persefone.it')->
                    subject("Pending update file for Google ARI");
                });
            } catch (\Throwable $th) {
                dd($th);
            }
        }
        
        return 0;
    }
}
