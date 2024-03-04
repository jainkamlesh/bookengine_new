<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use DateTimeZone;
use App\Models\Hotel;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use File;

class MakeGoogleHotelXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:googlexml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute every week and generate XML';

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
        Log::info('Inside Google XML Console Handle');
        
        $hotel_list = Hotel::where('google', 'Y')->get();
        $c = count($hotel_list);
        
        $google_xml = '<?xml version="1.0" encoding="UTF-8"?>
            <listings xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.gstatic.com/localfeed/local_feed.xsd">
            <language>en</language>';

        $temp_list = '';
        if ( isset($hotel_list) && count($hotel_list) > 0 ) {
            ##build booking json & post to Channel Manager
            foreach ( $hotel_list as $key => $hotel_detail ) {

                $hotel_id = $hotel_detail['id'];
                $hotel_name = $hotel_detail['name'];

                $address = $hotel_detail['address'];
                $city    = $hotel_detail['city'];
                $state   = $hotel_detail['state'];
                $postal_code = $hotel_detail['postal_code'];
                $country = $hotel_detail['country'];

                $latitude  = $hotel_detail['latitude'];
                $longitude = $hotel_detail['longtiude'];
                $mobile     = $hotel_detail['mobile'];
                $phone     = $hotel_detail['phone'];
                $category  = $hotel_detail['category'];
                // $category  = 'hotel';

                $star_rating  = $hotel_detail['star_rating'];
                $website      = $hotel_detail['website_url'];

                $banner_image = $hotel_detail['banner_image'];

                if ( $hotel_id && !is_null($hotel_id) && !empty($hotel_id) && $hotel_name && !is_null($hotel_name) && !empty($hotel_name) && $address && !is_null($address) && !empty($address) && $country && !is_null($country) && $latitude && !is_null($latitude) && !empty($latitude) && $longitude && !is_null($longitude) && !empty($longitude) ) {
                    
                    $temp_list .= '<listing>';
                    $temp_list .= '<id>'.$hotel_id.'</id>';
                    $temp_list .= '<name>'.$hotel_name.'</name>';
                    
                    $temp_list .= '<address format="simple">';
                    $temp_list .= '<component name="addr1">'.$address.'</component>';
                    if ( $city && !is_null($city) && !empty($city) ) {
                        $temp_list .= '<component name="city">'.$city.'</component>';
                    }
                    if ( $state && !is_null($state) && !empty($state) ) {
                        $temp_list .= '<component name="province">'.$state.'</component>';
                    }
                    if ( $postal_code && !is_null($postal_code) && !empty($postal_code) ) {
                        $temp_list .= '<component name="postal_code">'.$postal_code.'</component>';
                    }
                    $temp_list .= '</address>';

                    $temp_list .= '<country>'.$country.'</country>';
                    $temp_list .= '<latitude>'.$latitude.'</latitude>';
                    $temp_list .= '<longitude>'.$longitude.'</longitude>';

                    if ( $mobile && !is_null($mobile) && !empty($mobile) ) {
                        $temp_list .= '<phone type="mobile">'.$mobile.'</phone>';
                    }
                    if ( $phone && !is_null($phone) && !empty($phone) ) {
                        $temp_list .= '<phone type="main">'.$phone.'</phone>';
                    }

                    $attributes = '';
                    if ( $website && !is_null($website) && !empty($website) ) {
                        $attributes .= '<website>'.$website.'</website>';
                    }
                    if ( $star_rating && !is_null($star_rating) && !empty($star_rating) ) {
                        $attributes .= '<client_attr name="star_rating">'.$star_rating.'</client_attr>';
                    }

                    $image = '';
                    if ( $banner_image && !is_null($banner_image) && !empty($banner_image) ) {
                        $banner_url = 'http://localhost/persefone_be/public/public/images/hotel_banner/'.$banner_image;
                        $image = '<image type="photo" url="'.$banner_url.'">
                            <link>'.$banner_url.'</link>
                            <title>Hotel Banner</title>
                          </image>';
                    }

                    $is_content_set = 0;
                    if ( $attributes && !is_null($attributes) && !empty($attributes) ) {
                        $temp_list .= '<content>';
                        $temp_list .= '<attributes>'.$attributes.'</attributes>';
                        $is_content_set = 1;
                    }
                    if ( $image && !is_null($image) && !empty($image) ) {
                        if ( $is_content_set == 0 ) {
                            $temp_list .= '<content>';
                        }
                        $temp_list .= $image;
                        $is_content_set = 1;
                    }

                    if ( $is_content_set ) {
                        $temp_list .= '</content>';
                    }

                    $temp_list .= '</listing>';
                }
            }
        }

        $google_xml .= $temp_list.'</listings>';

        $google_xml = str_replace("&amp;","&",$google_xml);
        $google_xml = str_replace("&","&amp;",$google_xml);

        $public_path = public_path();

        $xml_path = $public_path.'/Feed.xml';

        File::put($xml_path,$google_xml);
  
    }
}
