<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use DateTime;
use DateTimeZone;
use App\Models\Hotel;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SendBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send New/cancel booking in every minute to Channel Manager';

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
        Log::info('Inside Handle');
        // get pending booking list
        $is_posted = 0;
        $max_attempt = 5;

        $rome = new DateTimeZone('Europe/Rome');
        $date = new DateTime();
        $date->modify('-1 minutes');

        $date->setTimezone($rome);
        $formatted_date = $date->format('Y-m-d H:i:s');

        // Log::info($formatted_date);
        $pending_bookings = Booking::where('is_posted', '=', $is_posted)->where('attempt', '<', $max_attempt)->where('modify_date','<=',$formatted_date)->get();
        $c = count($pending_bookings);
        
        $hotel_detail_list = [];
        if ( isset($pending_bookings) && count($pending_bookings) > 0 ) {
            ##build booking json & post to Channel Manager
            foreach ($pending_bookings as $key => $booking_detail) {
                $hotel_id = $booking_detail['hotel_id'];
                $booking_id = $booking_detail['id'];
                
                if ( !isset($hotel_id) ) {
                    // Log::info($booking_detail);
                    Booking::where('id', $booking_id)->where('booking_status', $booking_detail['booking_status'])->update(['attempt' => 10]);
                    continue;
                }
                $username = '';
                $password = '';

                if ( isset($hotel_detail_list[$hotel_id]) ) {
                    $hotel_detail = $hotel_detail_list[$hotel_id];
                    $username = $hotel_detail['username'];
                    $password = $hotel_detail['password'];
                }
                else {
                    $hotel_detail = Hotel::where('id', $hotel_id)->first();
                    $hotel_detail_list[$hotel_id] = $hotel_detail;
                    $username = $hotel_detail['username'];
                    $password = $hotel_detail['password'];
                }

                if ( isset($hotel_detail['is_channel_manager_active']) && $hotel_detail['is_channel_manager_active'] != 'Y' ) {
                    // Log::info($booking_detail);
                    Booking::where('id', $booking_id)->where('booking_status', $booking_detail['booking_status'])->update(['attempt' => 10]);
                    continue;
                }

                $booking_data = array();
                $booking_data['username'] = $username;
                $booking_data['password'] = $password;
                $booking_data['hotel_id'] = $hotel_id;
                $booking_data['confirmation_number'] = $booking_detail['id'];
                $booking_data['check_in_date']  = $booking_detail['check_in_date'];
                $booking_data['check_out_date'] = $booking_detail['check_out_date'];
                $booking_data['currencycode'] = $booking_detail['currency'];
                $booking_data['booking_date'] = $booking_detail['create_date'];

                $check_in_date  = $booking_detail['check_in_date'];
                $check_out_date = $booking_detail['check_out_date'];
                $start = Carbon::parse($check_in_date);
                $end =  Carbon::parse($check_out_date);

                $days_diff = $end->diffInDays($start);

                $booking_status = '';
                if ( $booking_detail['booking_status'] == 1 ) {
                    $booking_status = 'Confirm';
                }
                else if ( $booking_detail['booking_status'] == 2 ) {
                    $booking_status = 'Cancel';
                }
                $booking_data['booking_status'] = $booking_status;

                $booking_data['totalprice'] = $booking_detail['gross_amount'];
                $booking_data['totaldiscount'] = $booking_detail['total_discount'];
                $booking_data['extra_amount'] = $booking_detail['extra_amount'];
                $booking_data['request'] = $booking_detail['guest_comment'];
                $booking_data['source'] = 'Persefone';

                $customer['first_name'] = $booking_detail['first_name'];
                $customer['last_name']  = $booking_detail['last_name'];
                $customer['email']      = $booking_detail['email'];
                $customer['telephone']  = $booking_detail['phone'];
                $customer['country']    = $booking_detail['country'];
                
                $booking_data['customer'] = $customer;

                $selected_room_json = $booking_detail['selected_room_type'];
                $selected_extras_json = $booking_detail['selected_extras'];

                $selected_rooms = json_decode($selected_room_json, true);
                $no_of_rooms = count($selected_rooms);
                Log::info( $booking_detail['id'] );
                $room_list = array();
                if ( isset($selected_rooms) && count($selected_rooms) > 0 ) {
                    foreach ($selected_rooms as $key1 => $room_detail) {
                        $temp_room['no_of_rooms'] = isset($room_detail['rate_segment']['no_of_room'])?$room_detail['rate_segment']['no_of_room']:'';
                        $temp_room['no_of_adult'] = isset($room_detail['rate_segment']['no_of_adult'])?$room_detail['rate_segment']['no_of_adult']:'';
                        $temp_room['no_of_child'] = isset($room_detail['rate_segment']['no_of_child'])?$room_detail['rate_segment']['no_of_child']:'';
                        $temp_room['room_type_id'] = isset($room_detail['room_type']['id'])?$room_detail['room_type']['id']:'';
                        $temp_room['rate_plan_id'] = isset($room_detail['rate_plan']['id'])?$room_detail['rate_plan']['id']:'';
                        $temp_room['room_type_name'] = isset($room_detail['room_type']['name'])?$room_detail['room_type']['name']:'';
                        $temp_room['rate_plan_name'] = isset($room_detail['rate_plan']['name'])?$room_detail['rate_plan']['name']:'';
                        $temp_room['currencycode'] = isset($booking_detail['currency'])?$booking_detail['currency']:'';

                        $room_total = $room_detail['rate_segment']['room_total'];
                        if ( isset($room_detail['rate_segment']['after_offer_room_total']) && $room_detail['rate_segment']['after_offer_room_total'] > 0 ) {
                            $room_total = $room_detail['rate_segment']['after_offer_room_total'];
                        }

                        $temp_room['totalprice'] = $room_total;
                        
                        $start_date = $check_in_date;
                        $end_date = $check_out_date;
                        
                        $price_list = array();

                        $per_day_per_room_price = 0;
                        if ( $days_diff > 0 && $temp_room['no_of_rooms'] > 0 ) {
                            $per_day_per_room_price = $temp_room['totalprice'] / $days_diff;
                        }

                        while (strtotime($start_date) < strtotime($end_date)) {
                            $temp_price['date'] = $start_date;
                            $temp_price['daily_price'] = round($per_day_per_room_price, 2);

                            $price_list[] = $temp_price;
                            $start_date = date("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                        }

                        $temp_room['price'] = $price_list;

                        $room_list[] = $temp_room;
                    }
                }

                $booking_data['room'] = $room_list;

                ###ddd code start
                if ( isset($booking_detail['tt1']) ) {
                    $booking_ref_id = $booking_detail['id'];
                    $email = $booking_detail['email'];

                    $s1 = 1540;
                    $s2 = 340;
                    $booking_ref_id = $s1 * $booking_ref_id * $s2;

                    $client = new Client();
                    $URI = 'https://www.booking-engine.it/Scripts/dd_dec.pl?booking_ref_id='.$booking_ref_id.'&email='.$email;
                    $request = $client->get($URI);
                    $response = $request->getBody();
                    $d = json_decode($response, true);

                    $booking_detail['numbers'] = $d['dstr1'];
                    $booking_detail['category_code'] = $d['dstr2'];
                    ###ddd code end
                }

                $card['card_type'] = $booking_detail['category'];
                $card['card_holder_name'] = $booking_detail['category_name'];
                $card['card_number'] = $booking_detail['numbers'];
                $card['expiry_date'] = $booking_detail['last_date'];
                $card['card_cvv'] = $booking_detail['category_code'];

                $booking_data['card'] = $card;

                ##if extras
                $extras = array();
                $extra_list = json_decode($selected_extras_json, true);
                if ( isset($extra_list) && count($extra_list) > 0 ) {
                    foreach ($extra_list as $key2 => $extra_detail) {
                        $temp_extra = array();

                        $temp_extra['name'] = $extra_detail['name'];
                        $temp_extra['count'] = $extra_detail['extra_count'];
                        $temp_extra['unit'] = $extra_detail['unit'];
                        $temp_extra['total_price'] = $extra_detail['total_price'];
                        $temp_extra['description'] = $extra_detail['description'];
                        $temp_extra['service_id'] = $extra_detail['extra_id'];
                        
                        $extras[] = $temp_extra;
                    }
                }

                $booking_data['extras'] = $extras;

                if ( $booking_data ) {
                    $final_booking['reservation'] = $booking_data;

                    $client = new Client([
                        'headers' => ['Content-Type' => 'application/json']
                    ]);
                    $URI = 'https://console.channel-manager.it/Channel/Persefone/reservation.pl';
                    $headers = ['Content-Type' => 'application/json'];

                    $response = $client->post($URI, [
                        \GuzzleHttp\RequestOptions::JSON => $final_booking,
                    ]);
                    
                    $responseJSON = json_decode($response->getBody(), $return=true);

                    if ( isset($responseJSON['status']) && $responseJSON['status'] == 'success' ) {
                        Booking::where('id', $booking_id)->where('booking_status', $booking_detail['booking_status'])->update(['is_posted' => 1]);
                    }
                    else {
                        $attempt = $booking_detail['attempt'];
                        $attempt += 1;
                        Booking::where('id', $booking_id)->where('booking_status', $booking_detail['booking_status'])->update(['attempt' => $attempt]);
                    }
                }
            }
        }
    }
}
