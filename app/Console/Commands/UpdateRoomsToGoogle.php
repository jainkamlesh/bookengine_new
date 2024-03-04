<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use DateTimeZone;
use App\Models\Hotel;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\RatePlan;
use App\Models\RateType;
use App\Models\RoomType;
use File;

class UpdateRoomsToGoogle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateroom:google';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update each and every change room or rate or plan to google';

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
        Log::info("Updating Room/Rate/Rate Plan");

        ##update availability
        $path = storage_path('app/public/RatePlan');
        $files = File::files($path);

        ##update all property room/rate plan
        $list_of_rate_plans = array();

        ##for all the hotels
        $hotels = array();
        // $hotels = Hotel::where('google', 'Y')->get();
        // $hotels = Hotel::where('id', '78')->get();
        print(count($hotels));
        if ( isset($hotels) && count($hotels) ) {
            foreach ($hotels as $key => $value) {
                $hotel_id = $value->id;

                $existing_rate_plan = RatePlan::where('hotel_id', $hotel_id)->get();

                if ( isset($existing_rate_plan) && count($existing_rate_plan) )  {
                    foreach ($existing_rate_plan as $key => $value) {
                        $list_of_rate_plans[$value->id]['hotel_id']      = $hotel_id;
                        $list_of_rate_plans[$value->id]['room_type_id']  = $value->room_type_id;
                        $list_of_rate_plans[$value->id]['rate_type_id']  = $value->rate_type_id;
                        $list_of_rate_plans[$value->id]['rate_plan_id']  = $value->id;
                    }
                }
            }
        }

        foreach ($files as $key => $file) {
            $orig_file_name = basename($file);
            $orig_file_name = str_replace(".txt", "", $orig_file_name);

            $file_content = File::get($file);
            
            if ( isset($file_content) && !is_null($file_content) && $file_content != '' ) {
                $params = explode("_", $file_content);
                
                $type         = $params[0];
                $hotel_id     = $params[1];
                $room_type_id = $params[2];
                $rate_type_id = $params[3];
                $rate_plan_id = $params[4];

                $is_google_enabled = Hotel::where('id', $hotel_id)->where('google', 'Y')->count();
                if ( !$is_google_enabled ) {
                    continue;
                }

                // if ( $type == 'Hotel' ) {
                //     $existing_rate_plan = RatePlan::where('hotel_id', $hotel_id)->get();
                // }
                $existing_rate_plan = RatePlan::where('hotel_id', $hotel_id)->get();

                if ( isset($existing_rate_plan) && count($existing_rate_plan) )  {
                    foreach ($existing_rate_plan as $key => $value) {
                        $list_of_rate_plans[$value->id]['hotel_id']      = $hotel_id;
                        $list_of_rate_plans[$value->id]['room_type_id']  = $value->room_type_id;
                        $list_of_rate_plans[$value->id]['rate_type_id']  = $value->rate_type_id;
                        $list_of_rate_plans[$value->id]['rate_plan_id']  = $value->id;
                    }
                }
                else {
                    continue;
                }
            }
        }

        // foreach ($files as $key => $file) {
        //     $orig_file_name = basename($file);
        //     $orig_file_name = str_replace(".txt", "", $orig_file_name);

        //     $file_content = File::get($file);
            
        //     if ( isset($file_content) && !is_null($file_content) && $file_content != '' ) {
        //         $params = explode("_", $file_content);
                
        //         $type         = $params[0];
        //         $hotel_id     = $params[1];
        //         $room_type_id = $params[2];
        //         $rate_type_id = $params[3];
        //         $rate_plan_id = $params[4];

        //         $is_google_enabled = Hotel::where('id', $hotel_id)->where('google', 'Y')->count();
        //         if ( !$is_google_enabled ) {
        //             continue;
        //         }

        //         if ( $type == 'RoomType' ) {
        //             $existing_rate_plan = RatePlan::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->get();
        //         }
        //         if ( $type == 'RateType' ) {
        //             $existing_rate_plan = RatePlan::where('hotel_id', $hotel_id)->where('rate_type_id', $rate_type_id)->get();
        //         }
        //         if ( $type == 'RatePlan' ) {
        //             $existing_rate_plan = RatePlan::where('hotel_id', $hotel_id)->where('id', $rate_plan_id)->get();
        //         }

        //         if ( isset($existing_rate_plan) && count($existing_rate_plan) )  {
        //             foreach ($existing_rate_plan as $key => $value) {
        //                 $list_of_rate_plans[$value->id]['hotel_id']      = $hotel_id;
        //                 $list_of_rate_plans[$value->id]['room_type_id']  = $value->room_type_id;
        //                 $list_of_rate_plans[$value->id]['rate_type_id']  = $value->rate_type_id;
        //                 $list_of_rate_plans[$value->id]['rate_plan_id']  = $value->id;
        //             }
        //         }
        //         else {
        //             continue;
        //         }
        //     }
        // }
        // Log::info( $list_of_rate_plans );

        $package_group = array();
        if ( isset($list_of_rate_plans) && count($list_of_rate_plans) ) {
            foreach ($list_of_rate_plans as $rate_plan_id => $value) {
                $room_type_id = $value['room_type_id'];
                $package_group[$room_type_id][] = $rate_plan_id;
            }
        }

        $transaction_url = 'https://www.google.com/travel/hotels/uploads/property_data';

        if ( isset($list_of_rate_plans) && count($list_of_rate_plans) ) {
            ##get all the room types & make assosiative arrat with room id key
            ##get all the rate types & make assosiative arrat with rate id key
            ##get all the rate plans & make assosiative arrat with plan id key

            // $all_room_types = RoomType::where('hotel_id', $hotel_id)->get();
            // $all_rate_types = RateType::where('hotel_id', $hotel_id)->get();
            // $all_rate_plans = RatePlan::where('hotel_id', $hotel_id)->get();

            // $room_types = array();
            // $rate_types = array();
            // $rate_plans = array();
            // if ( isset($all_room_types) && count($all_room_types) ) {
            //     foreach ($all_room_types as $key => $value) {
            //         $room_types[$value->id] = $value;
            //     }
            // }
            // if ( isset($all_rate_types) && count($all_rate_types) ) {
            //     foreach ($all_rate_types as $key => $value) {
            //         $rate_types[$value->id] = $value;
            //     }
            // }
            // if ( isset($all_rate_plans) && count($all_rate_plans) ) {
            //     foreach ($all_rate_plans as $key => $value) {
            //         $rate_plans[$value->id] = $value;
            //     }
            // }

            // foreach ($package_group as $room_type_id => $rate_plan_list ) {
            //     $room_type_data = $room_types[$room_type_id];

            //     foreach ($rate_plan_list as $key1 => $rate_plan_id ) {
                    
            //     }
            // }

            $group_room_packahge_xml = array();
            foreach ($list_of_rate_plans as $rate_plan_id => $value) {
                $hotel_id     = $value['hotel_id'];
                $room_type_id = $value['room_type_id'];
                $rate_type_id = $value['rate_type_id'];

                $all_room_types = RoomType::where('hotel_id', $hotel_id)->get();
                $all_rate_types = RateType::where('hotel_id', $hotel_id)->get();
                $all_rate_plans = RatePlan::where('hotel_id', $hotel_id)->get();

                $room_types = array();
                $rate_types = array();
                $rate_plans = array();
                if ( isset($all_room_types) && count($all_room_types) ) {
                    foreach ($all_room_types as $key => $value) {
                        $room_types[$value->id] = $value;
                    }
                }
                if ( isset($all_rate_types) && count($all_rate_types) ) {
                    foreach ($all_rate_types as $key => $value) {
                        $rate_types[$value->id] = $value;
                    }
                }
                if ( isset($all_rate_plans) && count($all_rate_plans) ) {
                    foreach ($all_rate_plans as $key => $value) {
                        $rate_plans[$value->id] = $value;
                    }
                }

                if ( isset($room_types[$room_type_id]) ) {
                    $room_type_data = $room_types[$room_type_id];
                }
                if ( isset($rate_types[$rate_type_id]) ) {
                    $rate_type_data = $rate_types[$rate_type_id];
                }
                if ( isset($rate_plans[$rate_plan_id]) ) {
                    $rate_plan_data = $rate_plans[$rate_plan_id];
                }

                if ( !isset($room_type_data) ) {
                    continue;
                }
                if ( !isset($rate_type_data) ) {
                    continue;
                }
                if ( !isset($rate_plan_data) ) {
                    continue;
                }

                Log::info( $hotel_id );

                $timestamp = $time = date("Y-m-d H:i:s", time()); 
                $timestamp = str_replace(" ", "T", $timestamp);

                $rand_number = floor(microtime(true) * 1000);

                $room_type_name = $room_type_data['name'];
                $room_short_desc = $room_type_data['short_description'];
                $room_long_desc  = $room_type_data['long_description'];
                $base_adult = $room_type_data['base_adults'];
                $max_adult = $room_type_data['max_adults'];
                $max_child = $room_type_data['max_child'];
                $room_capacity = $room_type_data['room_capacity'];
                $room_image_prefix = 'https://bookingengine-12450.kxcdn.com/public/images/room_type/';
                $room_image_url = '';
                if ( isset($room_type_data['room_image']) ) {
                    $image_path = explode(",", $room_type_data['room_image']);
                    $room_image_url = $room_image_prefix.$image_path[0];
                }

                $rate_plan_name = $rate_plan_data['name'];
                $package_short_desc = $rate_type_data['short_description'];

                $refundable = 'false';
                if ( $rate_type_data['is_refundable'] == 'Y' ) {
                    $refundable = 'true';
                }
                $refundable_days = $rate_type_data['days_free_cancellation'];
                if ( !isset($refundable_days) ) {
                    $refundable_days = 0;
                }

                $room_short_desc = str_replace("<","&lt;",$room_short_desc);
                $room_short_desc = str_replace(">","&gt;",$room_short_desc);
                $room_short_desc = str_replace("\"","&quot;",$room_short_desc);

                $package_short_desc = str_replace("<","&lt;",$package_short_desc);
                $package_short_desc = str_replace(">","&gt;",$package_short_desc);
                $package_short_desc = str_replace("\"","&quot;",$package_short_desc);

                $xml = '<RoomData>
                            <RoomID>'.$room_type_id.'</RoomID>
                            <Name><Text text="'.$room_type_name.'" language="en" /></Name>
                            <Description>
                                <Text text="'.$room_short_desc.'" language="en" />
                            </Description>
                            <Capacity>'.$max_adult.'</Capacity>
                            <PhotoURL>
                                <Caption><Text text="'.$room_type_name.' Room Photo" language="en" /></Caption>
                                <URL>'.$room_image_url.'</URL>
                            </PhotoURL>
                        </RoomData>
                        <PackageData>
                            <PackageID>'.$rate_plan_id.'</PackageID>
                            <Name><Text text="'.$rate_plan_name.'" language="en" /></Name>
                            <Description><Text text="'.$package_short_desc.'" language="en" /></Description>';
                    if ( $refundable == 'false' ) {
                        $xml .= '<Refundable available="'.$refundable.'" />';
                    }
                    else {
                        $xml .= '<Refundable available="'.$refundable.'" refundable_until_days="'.$refundable_days.'" refundable_until_time="10:00:00" />';
                    }
                                
                    $xml .= '</PackageData>';
                    //     </PropertyDataSet>
                    // </Transaction>';

                $xml = str_replace("&amp;","&",$xml);
                $xml = str_replace("&","&amp;",$xml);

                // Log::info( $xml );

                if ( isset($group_room_packahge_xml[$hotel_id]) && $group_room_packahge_xml[$hotel_id] != '' ) {
                    $group_room_packahge_xml[$hotel_id] .= $xml;
                }
                else {
                    $group_room_packahge_xml[$hotel_id] = $xml;
                }
            }

            if ( !empty($group_room_packahge_xml) && count($group_room_packahge_xml) ) {
                foreach ($group_room_packahge_xml as $hotel_id => $pre_xml) {
                    
                    $timestamp = $time = date("Y-m-d H:i:s", time()); 
                    $timestamp = str_replace(" ", "T", $timestamp);

                    $rand_number = floor(microtime(true) * 1000);

                    $xml = '<?xml version="1.0" encoding="UTF-8"?>
                    <Transaction timestamp="'.$timestamp.'+02:00" id="'.$rand_number.'" partner="persefone_ari">
                        <PropertyDataSet action="Overlay">
                            <Property>'.$hotel_id.'</Property>';

                    $xml .= $pre_xml;

                    $xml .= '</PropertyDataSet></Transaction>';

                    Log::info( $xml );
                    if ( isset($xml) && $xml != '' ) {
                        $client = new \GuzzleHttp\Client([
                            'headers' => ['Content-Type' => 'application/xml']
                        ]);

                        $response = $client->post($transaction_url, [ 'body' => $xml ]);
                        
                        echo $response->getBody();
                        Log::info( $response->getBody() );
                    }
                }
            }
        }

        ##remove
        foreach ($files as $key => $file) {
            if (File::exists($file)) {
                unlink($file);
            }
        }
        
        return 0;
    }
}
