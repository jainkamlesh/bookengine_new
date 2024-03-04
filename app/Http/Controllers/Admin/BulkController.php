<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\heplers\helper;
use Auth;
use Str;
use App\Models\RoomType;
use App\Models\RatePlan;
use App\Models\InventoryMaster;
use App\Models\RateRestrictionMaster;
use App\Models\Logs;

class BulkController extends Controller
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

    public function index()
    {
        $data = array();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $data['hotel_id'] = $hotel_id;

        $roomType = RoomType::where('hotel_id', $hotel_id)->get();
        $countRoomType = $roomType->count();

        $data['roomType'] = $roomType;
        $data['countRoomType'] = $countRoomType;

        $ratePlan = RatePlan::where('hotel_id', $hotel_id)->get();
        $countRatePlan = $ratePlan->count();

        $data['ratePlan'] = $ratePlan;
        $data['countRatePlan'] = $countRatePlan;

        return view('admin.pages.hotel_panel.bulk_update', $data);
    }

    public function manageStoreBulkCalendarData(Request $request)
    {
        $today_date = date("Y-m-d");

        $today = date("Y-m-d H:i:s");

        $html = "fail";
        $data = array();
        $data_post = $request->all();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;

        if (isset($data_post['data_main_data']) && !empty($data_post['data_main_data'])) {
            $ar_main_data = array();
            $ar_main_data = $data_post['data_main_data'];
            foreach ($ar_main_data as $key => $value) {

                if (!empty($value)) {

                    foreach ($value as $a_key => $a_value) {

                        if ($key == "inventory") {

                            if (isset($a_value['room_type_id']) && !empty($a_value['room_type_id'])) {

                                $room_type_id = $a_value['room_type_id'];
                                $availability = trim($a_value['value']);

                                $start_date = trim($a_value['from_date']);
                                $start_date = date("Y-m-d", strtotime($start_date));
                                if (isset($a_value['to_date']) && !empty($a_value['to_date'])) {

                                    $end_date = trim($a_value['to_date']);
                                    $end_date = date("Y-m-d", strtotime($end_date));

                                    while (strtotime($start_date) <= strtotime($end_date)) {

                                        $update_ar = array();
                                        $update_ar['hotel_id'] = $hotel_id;
                                        $update_ar['room_type_id'] = $room_type_id;
                                        $update_ar['date'] = $start_date;

                                        $day = substr(strtolower(date("l", strtotime($start_date))), 0, 3);

                                        $availability = trim($a_value['days_vals'][$day]);

                                        $update_ar['availability'] = (int)$availability;

                                        $pre_availability = 0;

                                        $checkExists = array();
                                        $checkExists = InventoryMaster::where('hotel_id', '=', $hotel_id)->where('room_type_id', '=', $room_type_id)->whereDate('date', '=', $start_date)->first();
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
                                        $ar_value_data['updated_from'] = "Bulk Update";
                                        $ar_value_data['type'] = "inventory";
                                        $ar_value_data['update_type'] = "availability";
                                        $ar_value_data['old_value'] = $pre_availability;
                                        $ar_value_data['new_value'] = $availability;
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

                                        $html = "success";
                                        $start_date = date("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                                    }
                                }
                            }
                        } else {

                            if ($key != "inventory") {

                                if (isset($a_value['update_type']) && !empty($a_value['update_type'])) {

                                    $update_type = $a_value['update_type'];

                                    if (isset($a_value['rate_plan_id']) && !empty($a_value['rate_plan_id'])) {

                                        $rate_plan_id = $a_value['rate_plan_id'];

                                        $room_type_id = 0;
                                        $getData = array();
                                        $getData = RatePlan::where('hotel_id', '=', $hotel_id)->where('id', '=', $rate_plan_id)->first();
                                        if (isset($getData) && !empty($getData)) {

                                            $room_type_id = $getData->room_type_id;
                                        }

                                        if (!empty($room_type_id)) {

                                            $value_data = 1;
                                            if ($update_type == "closed" || $update_type == "cta" || $update_type == "ctd") {

                                                if ($a_value['value'] == "open") {
                                                    $value_data = 0;
                                                }

                                            } else {
                                                $value_data = trim($a_value['value']);
                                            }

                                            $start_date = trim($a_value['from_date']);
                                            $start_date = date("Y-m-d", strtotime($start_date));
                                            if (isset($a_value['to_date']) && !empty($a_value['to_date'])) {

                                                $end_date = trim($a_value['to_date']);
                                                $end_date = date("Y-m-d", strtotime($end_date));

                                                while (strtotime($start_date) <= strtotime($end_date)) {

                                                    $update_ar = array();
                                                    $update_ar['hotel_id'] = $hotel_id;
                                                    $update_ar['room_type_id'] = $room_type_id;
                                                    $update_ar['rate_plan_id'] = $rate_plan_id;
                                                    $update_ar['date'] = $start_date;

                                                    $day = substr(strtolower(date("l", strtotime($start_date))), 0, 3);

                                                    $value_data = 1;
                                                    if ($update_type == "closed" || $update_type == "cta" || $update_type == "ctd") {

                                                        if ($a_value['days_vals'][$day] == "open") {
                                                            $value_data = 0;
                                                        }

                                                    } else {
                                                        $value_data = trim($a_value['days_vals'][$day]);
                                                    }

                                                    $old_value = 0;
                                                    $new_value = 0;
                                                    if ($update_type == "rate") {

                                                        $update_ar['base_amount'] = $value_data;
                                                        $new_value = $update_ar['base_amount'];
                                                    }

                                                    if ($update_type == "ext_adult1_rate") {

                                                        $update_ar['extra_adult_1_amount'] = $value_data;
                                                        $new_value = $update_ar['extra_adult_1_amount'];
                                                    }

                                                    if ($update_type == "ext_adult2_rate") {

                                                        $update_ar['extra_adult_2_amount'] = $value_data;
                                                        $new_value = $update_ar['extra_adult_2_amount'];
                                                    }

                                                    if ($update_type == "ext_adult3_rate") {

                                                        $update_ar['extra_adult_3_amount'] = $value_data;
                                                        $new_value = $update_ar['extra_adult_3_amount'];
                                                    }

                                                    if ($update_type == "ext_adult4_rate") {

                                                        $update_ar['extra_adult_4_amount'] = $value_data;
                                                        $new_value = $update_ar['extra_adult_4_amount'];
                                                    }

                                                    if ($update_type == "child_age1_rate") {

                                                        $update_ar['child_age_1_rate'] = $value_data;
                                                        $new_value = $update_ar['child_age_1_rate'];
                                                    }

                                                    if ($update_type == "child_age2_rate") {

                                                        $update_ar['child_age_2_rate'] = $value_data;
                                                        $new_value = $update_ar['child_age_2_rate'];
                                                    }

                                                    if ($update_type == "child_age3_rate") {

                                                        $update_ar['child_age_3_rate'] = $value_data;
                                                        $new_value = $update_ar['child_age_3_rate'];
                                                    }

                                                    if ($update_type == "closed") {

                                                        $update_ar['closed'] = (int)$value_data;
                                                        $new_value = $update_ar['closed'];
                                                    }

                                                    if ($update_type == "cta") {

                                                        $update_ar['cta'] = (int)$value_data;
                                                        $new_value = $update_ar['cta'];
                                                    }

                                                    if ($update_type == "ctd") {

                                                        $update_ar['ctd'] = (int)$value_data;
                                                        $new_value = $update_ar['ctd'];
                                                    }

                                                    if ($update_type == "single_rate") {

                                                        $update_ar['single_amount'] = $value_data;
                                                        $new_value = $update_ar['single_amount'];
                                                    }

                                                    if ($update_type == "minstay") {

                                                        $update_ar['minstay'] = (int)$value_data;
                                                        $new_value = $update_ar['minstay'];
                                                    }

                                                    if ($update_type == "maxstay") {

                                                        $update_ar['maxstay'] = (int)$value_data;
                                                        $new_value = $update_ar['maxstay'];
                                                    }

                                                    $checkExists = array();
                                                    $checkExists = RateRestrictionMaster::where('hotel_id', '=', $hotel_id)
                                                        ->where('room_type_id', '=', $room_type_id)
                                                        ->where('rate_plan_id', '=', $rate_plan_id)
                                                        ->whereDate('date', '=', $start_date)
                                                        ->first();
                                                    if (isset($checkExists) && !empty($checkExists)) {

                                                        if ($update_type == "rate") {
                                                            $old_value = $checkExists->base_amount;
                                                        }

                                                        if ($update_type == "ext_adult1_rate") {
                                                            $old_value = $checkExists->extra_adult_1_amount;
                                                        }

                                                        if ($update_type == "ext_adult2_rate") {
                                                            $old_value = $checkExists->extra_adult_2_amount;
                                                        }

                                                        if ($update_type == "ext_adult3_rate") {
                                                            $old_value = $checkExists->extra_adult_3_amount;
                                                        }

                                                        if ($update_type == "ext_adult4_rate") {
                                                            $old_value = $checkExists->extra_adult_4_amount;
                                                        }

                                                        if ($update_type == "child_age1_rate") {
                                                            $old_value = $checkExists->child_age_1_rate;
                                                        }

                                                        if ($update_type == "child_age2_rate") {
                                                            $old_value = $checkExists->child_age_2_rate;
                                                        }

                                                        if ($update_type == "child_age3_rate") {
                                                            $old_value = $checkExists->child_age_3_rate;
                                                        }

                                                        if ($update_type == "closed") {
                                                            $old_value = $checkExists->closed;
                                                        }

                                                        if ($update_type == "cta") {
                                                            $old_value = $checkExists->cta;
                                                        }

                                                        if ($update_type == "ctd") {
                                                            $old_value = $checkExists->ctd;
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

                                                        $update_ar['updated_at'] = $today;
                                                        RateRestrictionMaster::where('id', $checkExists->id)->update($update_ar);

                                                    } else {

                                                        $update_ar['created_at'] = $today;
                                                        RateRestrictionMaster::insert($update_ar);
                                                    }

                                                    $logs_value_data = array();

                                                    $ar_value_data = array();
                                                    $ar_value_data['updated_from'] = "Bulk Update";
                                                    $ar_value_data['type'] = "restriction";
                                                    $ar_value_data['update_type'] = $update_type;
                                                    $ar_value_data['old_value'] = $old_value;
                                                    $ar_value_data['new_value'] = $new_value;
                                                    $ar_value_data['updated_date'] = $today;
                                                    $ar_value_data['ip_address'] = $this->getIpAddress();

                                                    $logs_value_data[] = $ar_value_data;


                                                    /****************************************************************************************************************************/

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

                                                    /****************************************************************************************************************************/
                                                    $html = "success";
                                                    $start_date = date("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        echo $html;
        exit;
    }

    public function store(Request $request)
    {
        return back();
    }

}
