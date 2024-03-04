<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use File;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Offer;
use Carbon\Carbon;
use App\Models\RateRestrictionMaster;
use App\Models\InventoryMaster;

class ARIUpdateGoogle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:google';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update ARI to google';

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
        Log::info( "Update ARI" );
        $p = shell_exec("ps -aux | grep 'artisan' | wc -l");

        $availabilitty_url = 'https://www.google.com/travel/hotels/uploads/ota/hotel_inv_count_notif';
        $rate_url = 'https://www.google.com/travel/hotels/uploads/ota/hotel_rate_amount_notif';
        $restriction_url = 'https://www.google.com/travel/hotels/uploads/ota/hotel_avail_notif';

        ##update availability
        $path = storage_path('app/public/Availability');
        $files = File::files($path);

        $group_availabile_hotels = array();
        foreach ($files as $key => $file) {
            $orig_file_name = basename($file);
            $orig_file_name = str_replace(".txt", "", $orig_file_name);

            $update_content = File::get($file);
            $parse_data = json_decode($update_content, true);
            
            $hotel_id = $parse_data['allotment_update_request']['hotel_code'];
            $room_types = $parse_data['allotment_update_request']['room_types'];

            $is_google_enabled = Hotel::where('google', 'Y')->count();
            if ( !$is_google_enabled ) {
                continue;
            }

            $inventory_string = '';
            if ( isset($room_types) && count($room_types) ) {
                foreach ($room_types as $key1 => $value1) {
                    $room_type_id = $value1['room_type_id'];
                    $dates = $value1['dates'];
                    if ( isset($dates) && count($dates) ) {
                        foreach ($dates as $key2 => $value2) {
                            $start_date = $value2['start_date'];
                            $end_date   = $value2['end_date'];
                            $allotment  = $value2['allotment'];

                            $inventory_string .= '<Inventory>
                                <StatusApplicationControl Start="'.$start_date.'" End="'.$end_date.'" InvTypeCode="'.$room_type_id.'" />
                                <InvCounts>
                                    <InvCount Count="'.$allotment.'" CountType="2" />
                                </InvCounts>
                            </Inventory>';
                        }
                    }
                }
            }

            $timestamp = $time = date("Y-m-d H:i:s", time()); 
            $timestamp = str_replace(" ", "T", $timestamp);

            $final_string = '';
            if ( isset($inventory_string) && $inventory_string != '' ) {
                $final_string = '<?xml version="1.0" encoding="UTF-8"?>
                    <OTA_HotelInvCountNotifRQ xmlns="http://www.opentravel.org/OTA/2003/05" EchoToken="'.$orig_file_name.'" TimeStamp="'.$timestamp.'+02:00" Version="3.0">
                        <POS>
                            <Source>
                            <RequestorID ID="persefone_ari" />
                            </Source>
                        </POS>
                        <Inventories HotelCode="'.$hotel_id.'">';
                $final_string .= $inventory_string;
                $final_string .= '</Inventories>
                    </OTA_HotelInvCountNotifRQ>';
            }

            // Log::info( $final_string );

            ##send to google
            if ( isset($final_string) && $final_string != '' ) {
                $client = new \GuzzleHttp\Client([
                    'headers' => ['Content-Type' => 'application/xml']
                ]);

                $response = $client->post($availabilitty_url, [ 'body' => $final_string ]);
                
                echo $response->getBody();
            }
        }

        ##remove
        foreach ($files as $key => $file) {
            if (File::exists($file)) {
                unlink($file);
            }
        }
        
        ##start rate update
        $path = storage_path('app/public/Rate');
        $files = File::files($path);
        Log::info( "Update rates" );;
        foreach ($files as $key => $file) {
            $orig_file_name = basename($file);
            $orig_file_name = str_replace(".txt", "", $orig_file_name);

            $update_content = File::get($file);
            Log::info( $update_content );

            $parse_data = json_decode($update_content, true);
            
            $hotel_id = $parse_data['rate_update_request']['hotel_code'];
            $room_types = $parse_data['rate_update_request']['room_types'];

            $hotel_data = Hotel::where('id', $hotel_id)->first();

            // $is_google_enabled = Hotel::where('google', 'Y')->count();
            if ( $hotel_data->google != 'Y'  ) {
                continue;
            }

            $city_tax = $hotel_data->city_tax;

            $rate_string = '';
            if ( isset($room_types) && count($room_types) ) {
                foreach ($room_types as $key1 => $value1) {
                    $room_type_id = $value1['room_type_id'];
                    $rate_plan_id = $value1['rate_plan_id'];
                    $dates = $value1['dates'];

                    $ret_data = $this->reform_rate( $hotel_id, $value1 );
                    
                    if ( isset($ret_data['app_guest']) ) {
                        $app_guest = $ret_data['app_guest'];
                    }
                    if ( isset($ret_data['max_adults']) ) {
                        $max_adults = $ret_data['max_adults'];
                    }
                    if ( isset($ret_data['group_rates']) ) {
                        $dates = $ret_data['group_rates'];
                    }

                    if ( isset($dates) && count($dates) ) {
                        foreach ($dates as $key2 => $value2) {
                            $start_date = $value2['start_date'];
                            $end_date   = $value2['end_date'];
                            if ( isset($value2['room_price']) ) {
                                $room_price = $value2['room_price'];
                            }
                            if ( isset($value2['single_price']) ) {
                                $single_price = $value2['single_price'];
                            }
                            if ( empty($app_guest) && isset($value2['app_guest'])) {
                                $app_guest = $value2['app_guest'];
                            }

                            if ( !isset($app_guest)) {
                                Log::info("App guest not set property id: $hotel_id, room: $room_type_id, plan: $rate_plan_id");
                            }

                            if ( !isset($room_price) || $room_price <= 0 || $room_price == '' ) {
                                continue;
                            }
                            if ( !isset($app_guest) || $app_guest == '' ) {
                                continue;
                            }

                            $closed = 0;
                            if ( isset($value2['closed']) ) {
                                $closed = $value2['closed'];
                            }

                            $rate_string .= '<RateAmountMessage>
                                <StatusApplicationControl Start="'.$start_date.'" End="'.$end_date.'" InvTypeCode="'.$room_type_id.'" RatePlanCode="'.$rate_plan_id.'" />
                                <Rates>
                                    <Rate>
                                        <BaseByGuestAmts>';

                            $temp_rate_string = '';
                            // if ( isset($single_price) && $single_price > 0 ) {
                            //     $temp_rate_string .= '<BaseByGuestAmt AmountBeforeTax="'.$single_price.'" CurrencyCode="EUR" NumberOfGuests="1" />';
                            //     if ( $app_guest && $app_guest > 1 ) {
                            //         for ( $i = 2; $i <= $app_guest; $i++ ) { 
                            //             $temp_rate_string .= '<BaseByGuestAmt AmountBeforeTax="'.$room_price.'" CurrencyCode="EUR" NumberOfGuests="'.$i.'" />';
                            //         }
                            //     }
                            // }
                            // else {
                            //     $temp_rate_string .= '<BaseByGuestAmt AmountBeforeTax="'.$room_price.'" CurrencyCode="EUR" NumberOfGuests="'.$app_guest.'" />';
                            // }

                            for ( $g = 1; $g <= $app_guest; $g++ ) { 

                                $final_city_tax = $city_tax * $g;
                                if ( $g == 1 ) {
                                    if ( isset($single_price) && $single_price > 0 ) {
                                        $final_single_price = $single_price + $final_city_tax;

                                        if ( $closed == 1 ) {
                                            $final_single_price = '-1';
                                        }
                                        
                                        $temp_rate_string .= '<BaseByGuestAmt AmountBeforeTax="'.$final_single_price.'" CurrencyCode="EUR" NumberOfGuests="'.$g.'" />';
                                    }
                                    else {
                                        $final_room_price = $room_price + $final_city_tax;
                                        if ( $closed == 1 ) {
                                            $final_room_price = '-1';
                                        }
                                        $temp_rate_string .= '<BaseByGuestAmt AmountBeforeTax="'.$final_room_price.'" CurrencyCode="EUR" NumberOfGuests="'.$g.'" />';
                                    }
                                }
                                elseif ( $g <= $app_guest ) {
                                    $final_room_price = $room_price + $final_city_tax;
                                    if ( $closed == 1 ) {
                                        $final_room_price = '-1';
                                    }
                                    $temp_rate_string .= '<BaseByGuestAmt AmountBeforeTax="'.$final_room_price.'" CurrencyCode="EUR" NumberOfGuests="'.$g.'" />';
                                }
                            }
                            
                            $extra_adult = 0;
                            if ( isset($max_adults) && isset($app_guest) ) {
                                $extra_adult = $max_adults - $app_guest;
                            }
                            $extra_adult_amount = $room_price;
                            if ( $extra_adult > 0 ) {
                                for ( $g = 1; $g <= $extra_adult ; $g++) { 
                                    $adt = $app_guest + $g;
                                    $adt_key = 'extra_adult_'.$g.'_amount';
                                    if ( isset($value2[$adt_key]) ) {
                                        $extra_adult_amount += $value2[$adt_key];
                                    }

                                    $final_city_tax = $city_tax * $g;
                                    $final_extra_adult_amount = $extra_adult_amount + $final_city_tax;
                                    if ( $closed == 1 ) {
                                        $final_extra_adult_amount = '-1';
                                    }

                                    $temp_rate_string .= '<BaseByGuestAmt AmountBeforeTax="'.$final_extra_adult_amount.'" CurrencyCode="EUR" NumberOfGuests="'.$adt.'" />';
                                }
                            }

                            // $is_price_set = 0;
                            // if ( isset($single_price) && $single_price > 0 ) {
                            //     $rate_string .= '<BaseByGuestAmt AmountBeforeTax="'.$single_price.'" CurrencyCode="EUR" NumberOfGuests="1" />';
                            //     $is_price_set = 1;
                            // }
                            // if ( isset($room_price) && $room_price > 0  ) {
                            //     $rate_string .= '<BaseByGuestAmt AmountBeforeTax="'.$room_price.'" CurrencyCode="EUR" NumberOfGuests="2" />';
                            //     $is_price_set = 1;
                            // }
                            $rate_string .= $temp_rate_string;

                            $rate_string .= ' 
                                        </BaseByGuestAmts>
                                    </Rate>
                                </Rates>
                            </RateAmountMessage>';
                        }
                    }
                }
            }
            Log::info( $rate_string );

            $timestamp = $time = date("Y-m-d H:i:s", time()); 
            $timestamp = str_replace(" ", "T", $timestamp);

            $final_string = '';
            if ( isset($rate_string) && $rate_string != '' ) {
                $final_string = '<?xml version="1.0" encoding="UTF-8"?>
                    <OTA_HotelRateAmountNotifRQ xmlns="http://www.opentravel.org/OTA/2003/05" EchoToken="'.$orig_file_name.'" TimeStamp="'.$timestamp.'+02:00" Version="3.0" NotifType="Delta" NotifScopeType="ProductRate">
                        <POS>
                            <Source>
                            <RequestorID ID="persefone_ari" />
                            </Source>
                        </POS>
                        <RateAmountMessages HotelCode="'.$hotel_id.'">';
                $final_string .= $rate_string;
                $final_string .= '</RateAmountMessages>
                    </OTA_HotelRateAmountNotifRQ>';
            }

            ##send to google
            if ( isset($final_string) && $final_string != '' ) {
                $client = new \GuzzleHttp\Client([
                    'headers' => ['Content-Type' => 'application/xml']
                ]);

                $response = $client->post($rate_url, [ 'body' => $final_string ]);
                
                echo $response->getBody();
            }
        }

        ##Update Restriction
        foreach ($files as $key => $file) {
            $orig_file_name = basename($file);
            $orig_file_name = str_replace(".txt", "", $orig_file_name);

            $update_content = File::get($file);
            $parse_data = json_decode($update_content, true);
            
            $hotel_id = $parse_data['rate_update_request']['hotel_code'];
            $room_types = $parse_data['rate_update_request']['room_types'];

            $is_google_enabled = Hotel::where('google', 'Y')->count();
            if ( !$is_google_enabled ) {
                continue;
            }
            
            $rate_string = '';
            if ( isset($room_types) && count($room_types) ) {
                foreach ($room_types as $key1 => $value1) {
                    $room_type_id = $value1['room_type_id'];
                    $rate_plan_id = $value1['rate_plan_id'];
                    $dates = $value1['dates'];

                    if ( isset($dates) && count($dates) ) {
                        foreach ($dates as $key2 => $value2) {
                            $start_date = $value2['start_date'];
                            $end_date   = $value2['end_date'];
                            $minstay = $value2['minstay'];
                            $maxstay = $value2['maxstay'];
                            $closed  = $value2['closed'];

                            $rate_string .= '<AvailStatusMessage>
                                <StatusApplicationControl Start="'.$start_date.'" End="'.$end_date.'" InvTypeCode="'.$room_type_id.'" RatePlanCode="'.$rate_plan_id.'" />';

                            $minstay_string = '';
                            if ( isset($minstay) && $minstay > 0 ) {
                                $minstay_string = '<LengthOfStay Time="'.$minstay.'" TimeUnit="Day"  MinMaxMessageType="SetMinLOS"></LengthOfStay>';
                            }

                            $maxstay_string = '';
                            if ( isset($maxstay) && $maxstay > 0 ) {
                                $maxstay_string = '<LengthOfStay Time="'.$maxstay.'" TimeUnit="Day"  MinMaxMessageType="SetMaxLOS"></LengthOfStay>';
                            }


                            if ( ( isset($minstay_string) && $minstay_string != '') || ( isset($maxstay_string) && $maxstay_string != '' )   ) {
                                $rate_string .= '<LengthsOfStay>';
                                $rate_string .= $minstay_string;
                                $rate_string .= $maxstay_string;
                                $rate_string .= '</LengthsOfStay>';
                            }

                            if ( isset($closed) ) {
                                $closed_string = '';
                                if ( $closed == 1 ) {
                                    $closed_string = 'Close';
                                }
                                else {
                                    $closed_string = 'Open';    
                                }

                                $rate_string .= '<RestrictionStatus Status="'.$closed_string.'" Restriction="Master"/>';
                            }
                            $rate_string .= '</AvailStatusMessage>';
                        }
                    }
                }
            }

            $timestamp = $time = date("Y-m-d H:i:s", time()); 
            $timestamp = str_replace(" ", "T", $timestamp);

            $final_string = '';
            if ( isset($rate_string) && $rate_string != '' ) {
                $final_string = '<?xml version="1.0" encoding="UTF-8"?>
                    <OTA_HotelAvailNotifRQ xmlns="http://www.opentravel.org/OTA/2003/05" EchoToken="'.$orig_file_name.'" TimeStamp="'.$timestamp.'+02:00" Version="3.0">
                        <POS>
                            <Source>
                            <RequestorID ID="persefone_ari" />
                            </Source>
                        </POS>
                        <AvailStatusMessages HotelCode="'.$hotel_id.'">';
                $final_string .= $rate_string;
                $final_string .= '</AvailStatusMessages>
                    </OTA_HotelAvailNotifRQ>';
            }

            ##send to google
            if ( isset($final_string) && $final_string != '' ) {
                $client = new \GuzzleHttp\Client([
                    'headers' => ['Content-Type' => 'application/xml']
                ]);

                $response = $client->post($restriction_url, [ 'body' => $final_string ]);
                
                echo $response->getBody();
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

    public function cmpr_date($a, $b) {
        return $a['date'] > $b['date'];
    }

    public function reform_rate($hotel_id, $value1)
    {
        $room_type_id = $value1['room_type_id'];
        $rate_plan_id = $value1['rate_plan_id'];
        $dates = $value1['dates'];

        ##get availability
        $availabilityData = InventoryMaster::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->where('date', '>=', date('Y-m-d'))->get();

        $availability_data = array();
        if ( !empty($availabilityData) && count($availabilityData) ) {
            foreach ($availabilityData as $k1 => $v1) {
                $date = $v1->date;
                $availability = $v1->availability;

                $availability_data[$date] = $availability;
            }
        }
        unset($availabilityData);

        $data = array();

        $app_guest;
        $max_adults;
        $room_detail = RoomType::where('hotel_id', $hotel_id)->where('id', $room_type_id)->first();
        if ( isset($room_detail) && isset($room_detail->base_adults) && $room_detail->base_adults > 0 ) {
            $app_guest = $room_detail->base_adults;
            $data['app_guest'] = $app_guest;
        }
        if ( isset($room_detail) && isset($room_detail->base_adults) && $room_detail->base_adults > 0 ) {
            $max_adults = $room_detail->max_adults;
            $data['max_adults'] = $max_adults;
        }

        ##get all offers for rooms
        $available_offers = array();
        $offers = Offer::where('hotel_id', $hotel_id)->get();

        $offer_days_percentage = array();
        if ( isset($offers) && count($offers) ) {
            foreach ($offers as $key => $offer) {
                // print_r($offer);
                $room_offer_matched = 0;
                $room_list = json_decode($offer['room_list'], true);

                if ( isset($room_list) && count($room_list) ) {
                    foreach ($room_list as $key1 => $room) {
                        if ( $room['room_list'] == $rate_plan_id ) {
                            $room_offer_matched = 1;
                            break;
                        }
                    }
                }
                
                if ( $room_offer_matched ) {
                    $valid_from = $offer['valid_from'];
                    $valid_to   = $offer['valid_to'];
                    $days_of_week   = json_decode($offer['days_of_week'], true);
                    $exclusive_days = json_decode($offer['exclusive_days'], true);
                    $percentage = $offer['discount_percentage'];

                    $exclusive_days_array = array();
                    if ( isset($exclusive_days) && count($exclusive_days) ) {
                        foreach ($exclusive_days as $key2 => $ex_day) {
                            $exclusive_days_array[$ex_day['exclusive_days']] = 1;
                        }
                    }

                    $days_of_week_array = array();
                    if ( isset($days_of_week) && count($days_of_week) ) {
                        foreach ($days_of_week as $key3 => $dow) {
                            $days_of_week_array[$dow['days_of_week']] = 1;
                        }
                    }

                    $start = Carbon::parse($valid_from);
                    $end =  Carbon::parse($valid_to);

                    $days_diff = $end->diffInDays($start);

                    for ( $i=0; $i <= $days_diff; $i++ ) { 
                        $new_date = date('Y-m-d', strtotime($valid_from . " +" . $i . "days"));
                        $day_of_week = date("l", strtotime($new_date));

                        if ( isset($exclusive_days_array[$new_date]) ) {
                            continue;
                        }

                        if ( !isset($days_of_week_array[$day_of_week]) ) {
                            continue;
                        }

                        if ( isset($offer_days_percentage[$new_date]) ) {
                            if ( $percentage > $offer_days_percentage[$new_date] ) {
                                $offer_days_percentage[$new_date] = $percentage;
                            }
                        }
                        else {
                            $offer_days_percentage[$new_date] = $percentage;
                        }
                    }
                }
            }
        }

        $final_rates = array();
        if ( isset($dates) && count($dates) ) {
            foreach ($dates as $key2 => $value2) {
                $start_date = $value2['start_date'];
                $end_date   = $value2['end_date'];

                ##get extra adult rate and child rate
                if ( $start_date <=> $end_date ) {
                    $extra_rates = RateRestrictionMaster::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->where('rate_plan_id', $rate_plan_id)->where('date','>=',$start_date)->where('date','<',$end_date)->get();
                }
                else {
                    $extra_rates = RateRestrictionMaster::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->where('rate_plan_id', $rate_plan_id)->where('date',$start_date)->get();    
                }

                $extra_rate_dates = array();
                if ( isset($extra_rates) && !empty($extra_rates) ) {
                    foreach ($extra_rates as $k => $v) {
                        $extra_rate_dates[$v['date']] = [
                            'extra_adult_1_amount' => $v['extra_adult_1_amount'],
                            'extra_adult_2_amount' => $v['extra_adult_2_amount'],
                            'extra_adult_3_amount' => $v['extra_adult_3_amount'],
                            'extra_adult_4_amount' => $v['extra_adult_4_amount'],
                        ];
                    }
                }

                $room_price;
                $single_price;
                if ( isset($value2['room_price']) ) {
                    $room_price = $value2['room_price'];
                }
                if ( isset($value2['single_price']) ) {
                    $single_price = $value2['single_price'];
                }
                else {
                    $single_price = '';
                }
                
                $start = Carbon::parse($start_date);
                $end =  Carbon::parse($end_date);

                $days_diff = $end->diffInDays($start);

                for ( $i=0; $i <= $days_diff; $i++ ) {
                    $new_date = date('Y-m-d', strtotime($start_date . " +" . $i . "days"));
                    $disc_perc = 0;
                    if ( isset($offer_days_percentage[$new_date]) ) {
                        $disc_perc = $offer_days_percentage[$new_date];
                    }
                    $final_room_price = $room_price;
                    $final_single_price = $single_price;
                    if ( $disc_perc > 0 ) {
                        if ( $final_room_price > 0 ) {
                            $disc_val = ( $final_room_price * $disc_perc ) / 100;
                            $final_room_price = $final_room_price - $disc_val;
                        }
                        if ( $final_single_price > 0 ) {
                            $disc_val = ( $final_single_price * $disc_perc ) / 100;
                            $final_single_price = $final_single_price - $disc_val;
                        }
                        if ( isset($extra_rate_dates[$new_date]['extra_adult_1_amount']) && $extra_rate_dates[$new_date]['extra_adult_1_amount'] > 0 ) {
                            $disc_val = ( $extra_rate_dates[$new_date]['extra_adult_1_amount'] * $disc_perc ) / 100;
                            $extra_rate_dates[$new_date]['extra_adult_1_amount'] = $extra_rate_dates[$new_date]['extra_adult_1_amount'] - $disc_val;
                        }
                        if ( isset($extra_rate_dates[$new_date]['extra_adult_2_amount']) && $extra_rate_dates[$new_date]['extra_adult_2_amount'] > 0 ) {
                            $disc_val = ( $extra_rate_dates[$new_date]['extra_adult_2_amount'] * $disc_perc ) / 100;
                            $extra_rate_dates[$new_date]['extra_adult_2_amount'] = $extra_rate_dates[$new_date]['extra_adult_2_amount'] - $disc_val;
                        }
                        if ( isset($extra_rate_dates[$new_date]['extra_adult_3_amount']) && $extra_rate_dates[$new_date]['extra_adult_3_amount'] > 0 ) {
                            $disc_val = ( $extra_rate_dates[$new_date]['extra_adult_3_amount'] * $disc_perc ) / 100;
                            $extra_rate_dates[$new_date]['extra_adult_3_amount'] = $extra_rate_dates[$new_date]['extra_adult_3_amount'] - $disc_val;
                        }
                        if ( isset($extra_rate_dates[$new_date]['extra_adult_4_amount']) && $extra_rate_dates[$new_date]['extra_adult_4_amount'] > 0 ) {
                            $disc_val = ( $extra_rate_dates[$new_date]['extra_adult_4_amount'] * $disc_perc ) / 100;
                            $extra_rate_dates[$new_date]['extra_adult_4_amount'] = $extra_rate_dates[$new_date]['extra_adult_4_amount'] - $disc_val;
                        }
                    }

                    $temp = array();
                    $temp['date'] = $new_date;
                    $temp['room_price'] = $final_room_price;
                    if ( isset($availability_data[$new_date]) && $availability_data[$new_date] <= 0 ) {
                        $temp['room_price'] = '-1';
                    }

                    if ( isset($final_single_price) ) {
                        $temp['single_price'] = $final_single_price;
                    }
                    else {
                        $temp['single_price'] = 0;
                    }
                    if ( isset($availability_data[$new_date]) && $availability_data[$new_date] <= 0 ) {
                        $temp['single_price'] = '-1';
                    }

                    if ( isset($extra_rate_dates[$new_date]['extra_adult_1_amount']) ) {
                        $temp['extra_adult_1_amount'] = $extra_rate_dates[$new_date]['extra_adult_1_amount'];
                    }
                    else {
                        $temp['extra_adult_1_amount'] = 0;
                    }
                    if ( isset($extra_rate_dates[$new_date]['extra_adult_2_amount']) ) {
                        $temp['extra_adult_2_amount'] = $extra_rate_dates[$new_date]['extra_adult_2_amount'];
                    }
                    else {
                        $temp['extra_adult_2_amount'] = 0;
                    }
                    if ( isset($extra_rate_dates[$new_date]['extra_adult_3_amount']) ) {
                        $temp['extra_adult_3_amount'] = $extra_rate_dates[$new_date]['extra_adult_3_amount'];
                    }
                    else {
                        $temp['extra_adult_3_amount'] = 0;
                    }
                    if ( isset($extra_rate_dates[$new_date]['extra_adult_4_amount']) ) {
                        $temp['extra_adult_4_amount'] = $extra_rate_dates[$new_date]['extra_adult_4_amount'];
                    }
                    else {
                        $temp['extra_adult_4_amount'] = 0;
                    }

                    $final_rates[$new_date] = $temp;
                }
            }
        }

        ksort($final_rates);

        $group_rates = array();
        if ( isset($final_rates) && count($final_rates) ) {
            unset($start_date);
            unset($end_date);
            unset($single_price);
            unset($room_price);
            unset($extra_adult_1_amount);
            unset($extra_adult_2_amount);
            unset($extra_adult_3_amount);
            unset($extra_adult_4_amount);
            $last_temp = array();

            $index = 0;
            foreach ($final_rates as $key => $rate) {
                
                if ( !isset($start_date) ) {
                    $start_date = $rate['date'];
                }
                $end_date = $rate['date'];
                if ( !isset($single_price) ) {
                    $single_price = $rate['single_price'];
                }
                if ( !isset($room_price) ) {
                    $room_price = $rate['room_price'];
                }
                if ( !isset($extra_adult_1_amount) ) {
                    $extra_adult_1_amount = $rate['extra_adult_1_amount'];
                }
                if ( !isset($extra_adult_2_amount) ) {
                    $extra_adult_2_amount = $rate['extra_adult_2_amount'];
                }
                if ( !isset($extra_adult_3_amount) ) {
                    $extra_adult_3_amount = $rate['extra_adult_3_amount'];
                }
                if ( !isset($extra_adult_4_amount) ) {
                    $extra_adult_4_amount = $rate['extra_adult_4_amount'];
                }
                
                if ( $single_price <=> $rate['single_price'] || $room_price <=> $rate['room_price'] || $extra_adult_1_amount <=> $rate['extra_adult_1_amount'] || $extra_adult_2_amount <=> $rate['extra_adult_2_amount'] || $extra_adult_3_amount <=> $rate['extra_adult_3_amount'] || $extra_adult_4_amount <=> $rate['extra_adult_4_amount'] ) {
                    
                    $temp = array();
                    $temp['start_date'] = $start_date;
                    // $temp['end_date'] = $final_rates[$index-1]['date'];
                    $temp['end_date'] = date('Y-m-d', strtotime($end_date . " -1 days"));
                    $temp['room_price'] = $room_price;
                    $temp['single_price'] = $single_price;
                    $temp['extra_adult_1_amount'] = $extra_adult_1_amount;
                    $temp['extra_adult_2_amount'] = $extra_adult_2_amount;
                    $temp['extra_adult_3_amount'] = $extra_adult_3_amount;
                    $temp['extra_adult_4_amount'] = $extra_adult_4_amount;

                    $group_rates[] = $temp;

                    $start_date = $rate['date'];
                    $end_date = $rate['date'];
                    $single_price = $rate['single_price'];
                    $room_price = $rate['room_price'];

                    $last_temp = array();
                    $last_temp['start_date'] = $start_date;
                    $last_temp['end_date'] = $end_date;
                    $last_temp['room_price'] = $room_price;
                    $last_temp['single_price'] = $single_price;
                    $last_temp['extra_adult_1_amount'] = $extra_adult_1_amount;
                    $last_temp['extra_adult_2_amount'] = $extra_adult_2_amount;
                    $last_temp['extra_adult_3_amount'] = $extra_adult_3_amount;
                    $last_temp['extra_adult_4_amount'] = $extra_adult_4_amount;
                }
                else {
                    $last_temp = array();
                    $last_temp['start_date'] = $start_date;
                    $last_temp['end_date'] = $end_date;
                    $last_temp['room_price'] = $room_price;
                    $last_temp['single_price'] = $single_price;
                    $last_temp['extra_adult_1_amount'] = $extra_adult_1_amount;
                    $last_temp['extra_adult_2_amount'] = $extra_adult_2_amount;
                    $last_temp['extra_adult_3_amount'] = $extra_adult_3_amount;
                    $last_temp['extra_adult_4_amount'] = $extra_adult_4_amount;
                }
                $index++;
            }

            if ( isset($last_temp) && count($last_temp) ) {
                $group_rates[] = $last_temp;
            }
        }
        // Log::info( $group_rates );
        $data['group_rates'] = $group_rates;

        return $data;
    }
}
