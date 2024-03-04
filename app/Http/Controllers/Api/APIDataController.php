<?php

namespace App\Http\Controllers\Api;

use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use DB;
use View;
use Validator;
use Hash;
use Input;
use Mail;
use Form;
use Auth;
use File;
use URL;
use Config;
use Image;
use Response;
use Storage;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Extra;
use App\Models\Hotel;
use App\Models\RatePlan;
use App\Models\RateRestrictionMaster;
use App\Models\RateType;
use App\Models\InventoryMaster;
use App\Models\Logs;

/**
 * Class APIDataController
 *
 * @package App\Http\Controllers\api
 */
class APIDataController extends Controller
{
    public function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /*Get Room Type & Rate Plan Mapping Request - Hotel user login*/
    public function userLogin(Request $request)
    {
        $data = array();
        $data['get_room_mapping']['status'] = "Error";

        $data_post = $request->json()->all();

        if (isset($data_post['get_room_mapping']) && !empty($data_post['get_room_mapping'])) {

            $key_post_data = $data_post['get_room_mapping'];

            if (isset($key_post_data['username']) && !empty($key_post_data['username'])) {

                if (isset($key_post_data['password']) && !empty($key_post_data['password'])) {

                    if (isset($key_post_data['hotel_code']) && !empty($key_post_data['hotel_code'])) {

                        $username = trim($key_post_data['username']);
                        $password = trim($key_post_data['password']);
                        $hotel_id = trim($key_post_data['hotel_code']);

                        $checkLoginData = array();
                        $checkLoginData = Admin::where('username', '=', $username)->where('hotel_id', '=', $hotel_id)->where('role', '=', 2)->first();
                        if (isset($checkLoginData) && !empty($checkLoginData)) {

                            if (Hash::check($password, $checkLoginData->password)) {

                                $data['get_room_mapping']['status'] = "Success";

                                $getRatePlanData = array();
                                $getRatePlanData = RatePlan::where('hotel_id', '=', $hotel_id)->where('is_master', 1)->get();
                                if (isset($getRatePlanData) && !empty($getRatePlanData)) {

                                    $data['get_room_mapping']['room_mapping_response'] = array();

                                    foreach ($getRatePlanData as $key => $value) {

                                        $child_data = array();
                                        $child_data['rate_plan_name'] = $value->name;
                                        $child_data['rate_plan_id'] = $value->id;
                                        $child_data['room_types'] = array();

                                        $getRoomTypeData = array();
                                        if (isset($value->room_type_id) && !empty($value->room_type_id)) {
                                            $getRoomTypeData = RoomType::where('id', '=', $value->room_type_id)->where('hotel_id', '=', $hotel_id)->get();
                                            if (isset($getRoomTypeData) && !empty($getRoomTypeData)) {

                                                foreach ($getRoomTypeData as $a_key => $a_value) {

                                                    $child_data['room_types'][] = array(
                                                        "room_type_name" => $a_value->name,
                                                        "room_type_id" => $a_value->id,
                                                        "base_adult" => $a_value->base_adults,
                                                        "max_adult" => $a_value->max_adults,
                                                        "max_child" => $a_value->max_child
                                                    );
                                                }
                                            }
                                        }
                                        $data['get_room_mapping']['room_mapping_response'][] = $child_data;
                                    }
                                }
                            } else {
                                $data['get_room_mapping']['reason'] = "incorrect password provided.";
                            }
                        } else {
                            $data['get_room_mapping']['reason'] = "incorrect username or hotel code provided.";
                        }

                    } else {

                        $data['get_room_mapping']['reason'] = "hotel code empty.";
                    }
                } else {

                    $data['get_room_mapping']['reason'] = "password empty.";
                }
            } else {

                $data['get_room_mapping']['reason'] = "username empty.";
            }
        } else {

            $data['get_room_mapping']['reason'] = "data empty.";
        }

        return Response::json($data, 200);
    }

    /*Availability Update based on room type Request*/
    public function updateAvailabilityRoomType(Request $request)
    {
        $today_date = date("Y-m-d");
        $today = date("Y-m-d H:i:s");

        $pass = 0;
        $data = array();
        $data['allotment_update_request']['status'] = "Error";

        $data_post = $request->json()->all();

        if (isset($data_post['allotment_update_request']) && !empty($data_post['allotment_update_request'])) {

            $key_post_data = $data_post['allotment_update_request'];

            if (isset($key_post_data['username']) && !empty($key_post_data['username'])) {

                if (isset($key_post_data['password']) && !empty($key_post_data['password'])) {

                    if (isset($key_post_data['hotel_code']) && !empty($key_post_data['hotel_code'])) {

                        $username = trim($key_post_data['username']);
                        $password = trim($key_post_data['password']);
                        $hotel_id = trim($key_post_data['hotel_code']);

                        $version = "1.0";
                        if (isset($key_post_data['version']) && !empty($key_post_data['version'])) {

                            $version = $key_post_data['version'];
                        }

                        $ar_room_types = array();
                        if (isset($key_post_data['room_types']) && !empty($key_post_data['room_types'])) {

                            $ar_room_types = $key_post_data['room_types'];
                        }

                        $checkLoginData = array();
                        $checkLoginData = Admin::where('username', '=', $username)->where('hotel_id', '=', $hotel_id)->where('role', '=', 2)->first();
                        if (isset($checkLoginData) && !empty($checkLoginData)) {

                            if (Hash::check($password, $checkLoginData->password)) {

                                if (isset($ar_room_types) && !empty($ar_room_types)) {

                                    foreach ($ar_room_types as $main_key => $main_value) {

                                        if (isset($main_value['room_type_id']) && !empty($main_value['room_type_id'])) {

                                            $room_type_id = 0;
                                            $room_type_id = trim($main_value['room_type_id']);

                                            $delete_ar = array();
                                            $delete_ar['hotel_id'] = $hotel_id;
                                            $delete_ar['room_type_id'] = $room_type_id;

                                            if (isset($main_value['dates']) && !empty($main_value['dates'])) {

                                                $ar_dates = array();
                                                $ar_dates = $main_value['dates'];

                                                if (!empty($ar_dates)) {

                                                    foreach ($ar_dates as $dt_key => $dt_value) {

                                                        if (isset($dt_value['start_date']) && !empty($dt_value['start_date'])) {

                                                            $start_date = trim($dt_value['start_date']);
                                                            $start_date = date("Y-m-d", strtotime($start_date));
                                                            if (isset($dt_value['end_date']) && !empty($dt_value['end_date'])) {

                                                                $end_date = trim($dt_value['end_date']);
                                                                $end_date = date("Y-m-d", strtotime($end_date));

                                                                $allotment = 0;
                                                                if (isset($dt_value['allotment'])) {
                                                                    $allotment = trim($dt_value['allotment']);
                                                                }

                                                                while (strtotime($start_date) <= strtotime($end_date)) {

                                                                    $update_ar = array();
                                                                    $update_ar['hotel_id'] = $hotel_id;
                                                                    $update_ar['room_type_id'] = $room_type_id;
                                                                    $update_ar['date'] = $start_date;
                                                                    $update_ar['availability'] = $allotment;

                                                                    $pre_availability = 0;
                                                                    $checkExists = array();
                                                                    $checkExists = InventoryMaster::where('hotel_id', '=', $hotel_id)->where('room_type_id', '=', $room_type_id)
                                                                        ->whereDate('date', '=', $start_date)->first();
                                                                    if (isset($checkExists) && !empty($checkExists)) {

                                                                        $pre_availability = $checkExists->availability;

                                                                        $update_ar['updated_at'] = $today;
                                                                        InventoryMaster::where('id', $checkExists->id)->update($update_ar);

                                                                    } else {

                                                                        $update_ar['created_at'] = $today;
                                                                        InventoryMaster::insert($update_ar);
                                                                    }

                                                                    $logs_value_data = array();

                                                                    $ar_value_data = array();
                                                                    $ar_value_data['updated_from'] = "API";
                                                                    $ar_value_data['type'] = "inventory";
                                                                    $ar_value_data['update_type'] = "availability";
                                                                    $ar_value_data['old_value'] = $pre_availability;
                                                                    $ar_value_data['new_value'] = $allotment;
                                                                    $ar_value_data['updated_date'] = $today;
                                                                    $ar_value_data['ip_address'] = $this->getIpAddress();

                                                                    $logs_value_data[] = $ar_value_data;

                                                                    /****************************************************************************************************************************/

                                                                    $ar_logData = array();
                                                                    $ar_logData['hotel_id'] = $hotel_id;
                                                                    $ar_logData['room_type_id'] = $room_type_id;
                                                                    $ar_logData['rate_plan_id'] = 0;
                                                                    $ar_logData['date'] = $start_date;

                                                                    $checkExists = array();
                                                                    $checkExists = Logs::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->whereDate('date', $start_date)->first();
                                                                    if (isset($checkExists) && !empty($checkExists)) {

                                                                        $new_logs_value_data = array();
                                                                        $old_logs_value_data = array();
                                                                        if (!empty($checkExists->value)) {

                                                                            $old_logs_value_data = @json_decode($checkExists->value, true);
                                                                        }

                                                                        if (!empty($old_logs_value_data)) {

                                                                            $new_logs_value_data = array_merge($old_logs_value_data, $logs_value_data);
                                                                        } else {

                                                                            $new_logs_value_data = $logs_value_data;
                                                                        }

                                                                        if (!empty($new_logs_value_data)) {

                                                                            $ar_logData['value'] = @json_encode($new_logs_value_data, true);
                                                                        }

                                                                        $ar_logData['updated_at'] = $today;
                                                                        Logs::where('id', $checkExists->id)->update($ar_logData);

                                                                    } else {

                                                                        $ar_logData['value'] = NULL;
                                                                        if (!empty($logs_value_data)) {

                                                                            $ar_logData['value'] = @json_encode($logs_value_data, true);
                                                                        }

                                                                        $ar_logData['created_at'] = $today;
                                                                        Logs::insert($ar_logData);
                                                                    }

                                                                    /****************************************************************************************************************************/

                                                                    $pass = 1;
                                                                    $start_date = date("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $data['allotment_update_request']['reason'] = "room type empty.";
                                }
                            } else {
                                $data['allotment_update_request']['reason'] = "incorrect password provided.";
                            }
                        } else {
                            $data['allotment_update_request']['reason'] = "incorrect username or hotel code provided.";
                        }
                    } else {

                        $data['allotment_update_request']['reason'] = "hotel code empty.";
                    }
                } else {
                    $data['allotment_update_request']['reason'] = "password empty.";
                }
            } else {

                $data['allotment_update_request']['reason'] = "username empty.";
            }
        } else {

            $data['allotment_update_request']['reason'] = "data empty.";
        }

        if ($pass == 1) {
            $data['allotment_update_request']['status'] = "Success";

            ##store data in temp file for update to google
            // $rand_number = rand(100000000000, 999999999999);
            $rand_number = floor(microtime(true) * 1000);
            $file_name = "Availability/".$rand_number.".txt";
            Storage::disk('public')->put($file_name, json_encode($data_post));

        } else {
            $data['allotment_update_request']['reason'] = "something went wrong.";
        }

        return Response::json($data, 200);
    }

    /*Rate Update based on room type Request*/
    public function updateRateRoomType(Request $request)
    {
        $today_date = date("Y-m-d");
        $today = date("Y-m-d H:i:s");

        $pass = 0;
        $data = array();
        $data['rate_update_request']['status'] = "Error";

        $data_post = $request->json()->all();

        if (isset($data_post['rate_update_request']) && !empty($data_post['rate_update_request'])) {

            $key_post_data = $data_post['rate_update_request'];

            if (isset($key_post_data['username']) && !empty($key_post_data['username'])) {

                if (isset($key_post_data['password']) && !empty($key_post_data['password'])) {

                    if (isset($key_post_data['hotel_code']) && !empty($key_post_data['hotel_code'])) {

                        $username = trim($key_post_data['username']);
                        $password = trim($key_post_data['password']);
                        $hotel_id = trim($key_post_data['hotel_code']);

                        $version = "1.0";
                        if (isset($key_post_data['version']) && !empty($key_post_data['version'])) {
                            $version = $key_post_data['version'];
                        }

                        $ar_room_types = array();
                        if (isset($key_post_data['room_types']) && !empty($key_post_data['room_types'])) {

                            $ar_room_types = $key_post_data['room_types'];
                        }

                        $checkLoginData = array();
                        $checkLoginData = Admin::where('username', '=', $username)->where('hotel_id', '=', $hotel_id)->where('role', '=', 2)->first();
                        if (isset($checkLoginData) && !empty($checkLoginData)) {

                            if (Hash::check($password, $checkLoginData->password)) {

                                if (isset($ar_room_types) && !empty($ar_room_types)) {

                                    foreach ($ar_room_types as $main_key => $main_value) {

                                        $room_type_id = 0;
                                        $rate_plan_id = 0;

                                        if (isset($main_value['room_type_id']) && !empty($main_value['room_type_id'])) {
                                            $room_type_id = trim($main_value['room_type_id']);
                                        }
                                        if (isset($main_value['rate_plan_id']) && !empty($main_value['rate_plan_id'])) {
                                            $rate_plan_id = trim($main_value['rate_plan_id']);
                                        }

                                        if (!empty($room_type_id) && !empty($rate_plan_id)) {

                                            $get_extra_config = RatePlan::where('hotel_id', $hotel_id)->where('id', $rate_plan_id)->first();

                                            if (isset($main_value['dates']) && !empty($main_value['dates'])) {

                                                $ar_dates = array();
                                                $ar_dates = $main_value['dates'];

                                                if (!empty($ar_dates)) {

                                                    foreach ($ar_dates as $dt_key => $dt_value) {

                                                        if (isset($dt_value['start_date']) && !empty($dt_value['start_date'])) {

                                                            $start_date = trim($dt_value['start_date']);
                                                            $start_date = date("Y-m-d", strtotime($start_date));

                                                            if (isset($dt_value['end_date']) && !empty($dt_value['end_date'])) {

                                                                $end_date = trim($dt_value['end_date']);
                                                                $end_date = date("Y-m-d", strtotime($end_date));

                                                                /*$room_price = 0;
                                                                if (isset($dt_value['room_price'])) {
                                                                    $room_price = trim($dt_value['room_price']);
                                                                }

                                                                $single_price = 0;
                                                                if (isset($dt_value['single_price'])) {
                                                                    $single_price = trim($dt_value['single_price']);
                                                                }*/


                                                                while (strtotime($start_date) <= strtotime($end_date)) {

                                                                    $update_ar = array();
                                                                    $update_ar['hotel_id'] = $hotel_id;
                                                                    $update_ar['room_type_id'] = $room_type_id;
                                                                    $update_ar['rate_plan_id'] = $rate_plan_id;
                                                                    $update_ar['date'] = $start_date;

                                                                    $update_type = "";
                                                                    $old_value = 0;
                                                                    $new_value = 0;
                                                                    if (isset($dt_value['room_price']) && !is_null($dt_value['room_price']) && !empty($dt_value['room_price']) ) {

                                                                        $update_ar['base_amount'] = $dt_value['room_price'];
                                                                        $new_value = $update_ar['base_amount'];
                                                                        $update_type = "rate";
                                                                    }

                                                                    if (isset($dt_value['single_price']) && !is_null($dt_value['single_price']) && !empty($dt_value['single_price']) ) {

                                                                        $update_ar['single_amount'] = $dt_value['single_price'];
                                                                        $new_value = $update_ar['single_amount'];
                                                                        $update_type = "single_rate";
                                                                    }

                                                                    if ( ( !empty($get_extra_config['ext_adult1_rate_plus']) && !is_null($get_extra_config['ext_adult1_rate_plus']) ) || ( !empty($get_extra_config['ext_adult1_rate_percentage']) && !is_null($get_extra_config['ext_adult1_rate_percentage']) ) ) {

                                                                        $plus = $get_extra_config['ext_adult1_rate_plus'];
                                                                        $perc = $get_extra_config['ext_adult1_rate_percentage'];
                                                                        $base_price = $dt_value['room_price'];
                                                                        if ( isset($plus) && !is_null($plus) && !empty($plus)) {
                                                                            $ext_value = $plus;
                                                                        }
                                                                        if ( isset($perc) && !is_null($perc) && !empty($perc) ) {
                                                                            if ( isset($ext_value) ) {
                                                                                $ext_value = $ext_value + ( ( $base_price * $perc ) / 100 );
                                                                            }
                                                                            else {
                                                                                $ext_value = ( ( $base_price * $perc ) / 100 );    
                                                                            }
                                                                        }
                                                                        if ( isset($ext_value) ) {
                                                                            $update_ar['extra_adult_1_amount'] = $ext_value;
                                                                            unset($ext_value);
                                                                        }
                                                                    }
                                                                    if ( ( !empty($get_extra_config['ext_adult2_rate_plus']) && !is_null($get_extra_config['ext_adult2_rate_plus']) ) || ( !empty($get_extra_config['ext_adult2_rate_percentage']) && !is_null($get_extra_config['ext_adult2_rate_percentage']) ) ) {

                                                                        $plus = $get_extra_config['ext_adult2_rate_plus'];
                                                                        $perc = $get_extra_config['ext_adult2_rate_percentage'];
                                                                        $base_price = $dt_value['room_price'];
                                                                        if ( isset($plus) && !is_null($plus) && !empty($plus) ) {
                                                                            $ext_value = $plus;
                                                                        }
                                                                        if ( isset($perc) && !is_null($perc) && !empty($perc) ) {
                                                                            if ( isset($ext_value) ) {
                                                                                $ext_value = $ext_value + ( ( $base_price * $perc ) / 100 );
                                                                            }
                                                                            else {
                                                                                $ext_value = ( ( $base_price * $perc ) / 100 );    
                                                                            }
                                                                        }
                                                                        if ( isset($ext_value) ) {
                                                                            $update_ar['extra_adult_2_amount'] = $ext_value;
                                                                            unset($ext_value);
                                                                        }
                                                                    }
                                                                    if ( ( !empty($get_extra_config['ext_adult3_rate_plus']) && !is_null($get_extra_config['ext_adult3_rate_plus']) ) || ( !empty($get_extra_config['ext_adult3_rate_percentage']) && !is_null($get_extra_config['ext_adult3_rate_percentage']) ) ) {

                                                                        $plus = $get_extra_config['ext_adult3_rate_plus'];
                                                                        $perc = $get_extra_config['ext_adult3_rate_percentage'];
                                                                        $base_price = $dt_value['room_price'];
                                                                        if ( isset($plus) && !is_null($plus) && !empty($plus) ) {
                                                                            $ext_value = $plus;
                                                                        }
                                                                        if ( isset($perc) && !is_null($perc) && !empty($perc) ) {
                                                                            if ( isset($ext_value) ) {
                                                                                $ext_value = $ext_value + ( ( $base_price * $perc ) / 100 );
                                                                            }
                                                                            else {
                                                                                $ext_value = ( ( $base_price * $perc ) / 100 );    
                                                                            }
                                                                        }
                                                                        if ( isset($ext_value) ) {
                                                                            $update_ar['extra_adult_3_amount'] = $ext_value;
                                                                            unset($ext_value);
                                                                        }
                                                                    }
                                                                    if ( ( !empty($get_extra_config['ext_adult4_rate_plus']) && !is_null($get_extra_config['ext_adult4_rate_plus']) ) || ( !empty($get_extra_config['ext_adult4_rate_percentage']) && !is_null($get_extra_config['ext_adult4_rate_percentage']) ) ) {

                                                                        $plus = $get_extra_config['ext_adult4_rate_plus'];
                                                                        $perc = $get_extra_config['ext_adult4_rate_percentage'];
                                                                        $base_price = $dt_value['room_price'];
                                                                        if ( isset($plus) && !is_null($plus) && !empty($plus) ) {
                                                                            $ext_value = $plus;
                                                                        }
                                                                        if ( isset($perc) && !is_null($perc) && !empty($perc) ) {
                                                                            if ( isset($ext_value) ) {
                                                                                $ext_value = $ext_value + ( ( $base_price * $perc ) / 100 );
                                                                            }
                                                                            else {
                                                                                $ext_value = ( ( $base_price * $perc ) / 100 );    
                                                                            }
                                                                        }
                                                                        if ( isset($ext_value) ) {
                                                                            $update_ar['extra_adult_4_amount'] = $ext_value;
                                                                            unset($ext_value);
                                                                        }
                                                                    }

                                                                    if ( ( !empty($get_extra_config['child_age1_rate_plus']) && !is_null($get_extra_config['child_age1_rate_plus']) ) || ( !empty($get_extra_config['child_age1_rate_percentage']) && !is_null($get_extra_config['child_age1_rate_percentage']) ) ) {

                                                                        $plus = $get_extra_config['child_age1_rate_plus'];
                                                                        $perc = $get_extra_config['child_age1_rate_percentage'];
                                                                        $base_price = $dt_value['room_price'];
                                                                        if ( isset($plus) && !is_null($plus) && !empty($plus) ) {
                                                                            $ext_value = $plus;
                                                                        }
                                                                        if ( isset($perc) && !is_null($perc) && !empty($perc) ) {
                                                                            if ( isset($ext_value) ) {
                                                                                $ext_value = $ext_value + ( ( $base_price * $perc ) / 100 );
                                                                            }
                                                                            else {
                                                                                $ext_value = ( ( $base_price * $perc ) / 100 );    
                                                                            }
                                                                        }
                                                                        if ( isset($ext_value) ) {
                                                                            $update_ar['child_age_1_rate'] = $ext_value;
                                                                            unset($ext_value);
                                                                        }
                                                                    }
                                                                    if ( ( !empty($get_extra_config['child_age2_rate_plus']) && !is_null($get_extra_config['child_age2_rate_plus']) ) || ( !empty($get_extra_config['child_age2_rate_percentage']) && !is_null($get_extra_config['child_age2_rate_percentage']) ) ) {

                                                                        $plus = $get_extra_config['child_age2_rate_plus'];
                                                                        $perc = $get_extra_config['child_age2_rate_percentage'];
                                                                        $base_price = $dt_value['room_price'];
                                                                        if ( isset($plus) && !is_null($plus) && !empty($plus) ) {
                                                                            $ext_value = $plus;
                                                                        }
                                                                        if ( isset($perc) && !is_null($perc) && !empty($perc) ) {
                                                                            if ( isset($ext_value) ) {
                                                                                $ext_value = $ext_value + ( ( $base_price * $perc ) / 100 );
                                                                            }
                                                                            else {
                                                                                $ext_value = ( ( $base_price * $perc ) / 100 );    
                                                                            }
                                                                        }
                                                                        if ( isset($ext_value) ) {
                                                                            $update_ar['child_age_2_rate'] = $ext_value;
                                                                            unset($ext_value);
                                                                        }
                                                                    }
                                                                    if ( ( !empty($get_extra_config['child_age3_rate_plus']) && !is_null($get_extra_config['child_age3_rate_plus']) ) || ( !empty($get_extra_config['child_age3_rate_percentage']) && !is_null($get_extra_config['child_age3_rate_percentage']) ) ) {

                                                                        $plus = $get_extra_config['child_age3_rate_plus'];
                                                                        $perc = $get_extra_config['child_age3_rate_percentage'];
                                                                        $base_price = $dt_value['room_price'];
                                                                        if ( isset($plus) && !is_null($plus) && !empty($plus) ) {
                                                                            $ext_value = $plus;
                                                                        }
                                                                        if ( isset($perc) && !is_null($perc) && !empty($perc) ) {
                                                                            if ( isset($ext_value) ) {
                                                                                $ext_value = $ext_value + ( ( $base_price * $perc ) / 100 );
                                                                            }
                                                                            else {
                                                                                $ext_value = ( ( $base_price * $perc ) / 100 );    
                                                                            }
                                                                        }
                                                                        if ( isset($ext_value) ) {
                                                                            $update_ar['child_age_3_rate'] = $ext_value;
                                                                            unset($ext_value);
                                                                        }
                                                                    }


                                                                    if (isset($dt_value['closed'])) {

                                                                        $update_ar['closed'] = $dt_value['closed'];
                                                                        $new_value = $update_ar['closed'];
                                                                        $update_type = "closed";
                                                                    }

                                                                    if (isset($dt_value['minstay'])) {

                                                                        $update_ar['minstay'] = $dt_value['minstay'];
                                                                        $new_value = $update_ar['minstay'];
                                                                        $update_type = "minstay";
                                                                    }

                                                                    if (isset($dt_value['maxstay'])) {

                                                                        $update_ar['maxstay'] = $dt_value['maxstay'];
                                                                        $new_value = $update_ar['maxstay'];
                                                                        $update_type = "maxstay";
                                                                    }

                                                                    $checkExists = array();
                                                                    $checkExists = RateRestrictionMaster::where('hotel_id', '=', $hotel_id)
                                                                        ->where('room_type_id', '=', $room_type_id)
                                                                        ->where('rate_plan_id', '=', $rate_plan_id)
                                                                        ->whereDate('date', '=', $start_date)
                                                                        ->first();
                                                                    if (isset($checkExists) && !empty($checkExists)) {

                                                                        if (!empty($update_type)) {

                                                                            if ($update_type == "rate") {
                                                                                $old_value = $checkExists->base_amount;
                                                                            }

                                                                            if ($update_type == "closed") {
                                                                                $old_value = $checkExists->closed;
                                                                            }

                                                                            if ($update_type == "single_rate") {
                                                                                $old_value = $checkExists->single_amount;
                                                                            }

                                                                            if ($update_type == "minstay") {
                                                                                $old_value = $checkExists->minstay;
                                                                            }

                                                                            if ($update_type == "maxstay") {
                                                                                $old_value = $checkExists->maxstay;
                                                                            }
                                                                        }

                                                                        $update_ar['updated_at'] = $today;
                                                                        RateRestrictionMaster::where('id', $checkExists->id)->update($update_ar);

                                                                    } else {

                                                                        $update_ar['created_at'] = $today;
                                                                        RateRestrictionMaster::insert($update_ar);
                                                                    }

                                                                    if (!empty($update_type)) {

                                                                        $logs_value_data = array();

                                                                        $ar_value_data = array();
                                                                        $ar_value_data['updated_from'] = "API";
                                                                        $ar_value_data['type'] = "restriction";
                                                                        $ar_value_data['update_type'] = $update_type;
                                                                        $ar_value_data['old_value'] = $old_value;
                                                                        $ar_value_data['new_value'] = $new_value;
                                                                        $ar_value_data['updated_date'] = $today;
                                                                        $ar_value_data['ip_address'] = $this->getIpAddress();

                                                                        $logs_value_data[] = $ar_value_data;
                                                                    }

                                                                    /****************************************************************************************************************************/
                                                                    if (!empty($logs_value_data)) {

                                                                        $ar_logData = array();
                                                                        $ar_logData['hotel_id'] = $hotel_id;
                                                                        $ar_logData['room_type_id'] = $room_type_id;
                                                                        $ar_logData['rate_plan_id'] = $rate_plan_id;
                                                                        $ar_logData['date'] = $start_date;

                                                                        $checkExists = array();
                                                                        $checkExists = Logs::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->whereDate('date', $start_date)->first();
                                                                        if (isset($checkExists) && !empty($checkExists)) {

                                                                            $new_logs_value_data = array();
                                                                            $old_logs_value_data = array();
                                                                            if (!empty($checkExists->value)) {

                                                                                $old_logs_value_data = @json_decode($checkExists->value, true);
                                                                            }

                                                                            if (!empty($old_logs_value_data)) {

                                                                                $new_logs_value_data = array_merge($old_logs_value_data, $logs_value_data);
                                                                            } else {

                                                                                $new_logs_value_data = $logs_value_data;
                                                                            }

                                                                            if (!empty($new_logs_value_data)) {

                                                                                $ar_logData['value'] = @json_encode($new_logs_value_data, true);
                                                                            }

                                                                            $ar_logData['updated_at'] = $today;
                                                                            Logs::where('id', $checkExists->id)->update($ar_logData);

                                                                        } else {

                                                                            $ar_logData['value'] = NULL;
                                                                            if (!empty($logs_value_data)) {

                                                                                $ar_logData['value'] = @json_encode($logs_value_data, true);
                                                                            }

                                                                            $ar_logData['created_at'] = $today;
                                                                            Logs::insert($ar_logData);
                                                                        }
                                                                    }
                                                                    /****************************************************************************************************************************/

                                                                    $pass = 1;
                                                                    $start_date = date("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $data['rate_update_request']['reason'] = "room type empty.";
                                }
                            } else {

                                $data['rate_update_request']['reason'] = "incorrect password provided.";
                            }
                        } else {

                            $data['rate_update_request']['reason'] = "incorrect username or hotel code provided.";
                        }
                    } else {

                        $data['rate_update_request']['reason'] = "hotel code empty.";
                    }
                } else {

                    $data['rate_update_request']['reason'] = "password empty.";
                }
            } else {

                $data['rate_update_request']['reason'] = "username empty.";
            }
        } else {

            $data['rate_update_request']['reason'] = "data empty.";
        }

        if ($pass == 1) {

            $data['rate_update_request']['status'] = "Success";

            ##store data in temp file for update to google
            // $rand_number = rand(100000000000, 999999999999);
            $rand_number = floor(microtime(true) * 1000);
            // $file_name = "Rate_".$rand_number.".txt";
            $file_name = "Rate/".$rand_number.".txt";
            Storage::disk('public')->put($file_name, json_encode($data_post));
        } else {

            $data['rate_update_request']['reason'] = "something went wrong.";
        }

        return Response::json($data, 200);
    }
}