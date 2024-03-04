<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\heplers\helper;
use App\Models\InventoryMaster;
use App\Models\RateRestrictionMaster;
use App\Models\RoomType;
use App\Models\RatePlan;
use App\Models\RateType;
use App\Models\Logs;


class InventoryMasterController extends Controller
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

    public function calender()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $roomType = RoomType::with('getRoomType')->where('hotel_id', $hotel_id)->get();
        $roomTypeCnt = $roomType->count();

        /*$roomType[0]->id*/
        /*get room availability data*/
        $availabilityData = InventoryMaster::where('hotel_id', $hotel_id)->where('date', '>=', date('Y-m-d'))->orderBy('date', 'ASC')->get();
        $availabilityDataCnt = $availabilityData->count();

        /*Get RateRestrictionMaster data*/
        $rateMaster = RateRestrictionMaster::where('hotel_id', $hotel_id)->where('date', '>=', date('Y-m-d'))->orderBy('date', 'ASC')->distinct()->get();
        $rateMasterCnt = $rateMaster->count();

        $ratePlan = RatePlan::where('hotel_id', $hotel_id)->orderBy('id', 'ASC')->get();

        $data = array();
        $data['roomType'] = $roomType;
        $data['roomTypeCnt'] = $roomTypeCnt;

        $data['availabilityData'] = $availabilityData;
        $data['availabilityDataCnt'] = $availabilityDataCnt;

        $data['rateMaster'] = $rateMaster;
        $data['rateMasterCnt'] = $rateMasterCnt;

        $data['ratePlan'] = $ratePlan;

        return view('admin.pages.hotel_panel.calender.index', $data);
    }

    public function getCalendarData(Request $request)
    {
        $data = array();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $data['hotel_id'] = $hotel_id;

        $data_post = $request->all();

        $value_rates_plan = 0;
        $value_room_type = 0;
        $value_month_year = "";

        $current_month = date("m");
        $current_year = date("Y");

        $data['current_month'] = $current_month;
        $data['current_year'] = $current_year;

        $selected_month = $current_month;
        $selected_year = $current_year;

        $str_current_MY = strtotime(date("d-m-Y"));
        $str_selected_MY = $str_current_MY;

        if (isset($data_post['data_value_rates_plan']) && !empty($data_post['data_value_rates_plan'])) {
            $value_rates_plan = $data_post['data_value_rates_plan'];
        }

        if (isset($data_post['data_value_room_type']) && !empty($data_post['data_value_room_type'])) {
            $value_room_type = $data_post['data_value_room_type'];
        }

        $data['value_rates_plan'] = $value_rates_plan;
        $data['value_room_type'] = $value_room_type;

        if (isset($data_post['data_value_month_year']) && !empty($data_post['data_value_month_year'])) {

            $value_month_year = $data_post['data_value_month_year'];

            $get_month_year = date("d") . "-" . $value_month_year;
            $get_month_year = date("d-m-Y", strtotime($get_month_year));
            $str_selected_MY = strtotime($get_month_year);

            $selected_month = date("m", strtotime($get_month_year));
            $selected_year = date("Y", strtotime($get_month_year));

            /*sandro changes*/
            list($selected_month,$selected_year)=explode("-",$value_month_year);
        }

        $set_global_date = date("Y-m-d");
        if ($str_current_MY != $str_selected_MY) {
            $set_global_date = $selected_year . "-" . $selected_month . "-01";
            $set_global_date = date("Y-m-d", strtotime($set_global_date));
        }

        $data['selected_month'] = $selected_month;
        $data['selected_year'] = $selected_year;

        $data['set_global_date'] = $set_global_date;

        $ar_get_selected_root_typeID = array();
        if (!empty($value_room_type)) {
            array_push($ar_get_selected_root_typeID, $value_room_type);
        }

        /*$ratePlan = RatePlan::join('room_types', 'rate_plans.room_type_id', '=', 'room_types.id')
            ->where('rate_plans.hotel_id', $hotel_id)
            ->where(function ($query) use ($value_rates_plan, $value_room_type) {
                if (!empty($value_rates_plan)) {
                    $query->where('rate_plans.id', $value_rates_plan);
                }

                if (!empty($value_room_type)) {
                    $query->where('rate_plans.room_type_id', $value_room_type);
                }

            })->orderBy('rate_plans.id', 'ASC')->select('rate_plans.*')->get();
        $data['ratePlan'] = $ratePlan;*/

        $ratePlan = RatePlan::join('room_types', 'rate_plans.room_type_id', '=', 'room_types.id')
            ->where('rate_plans.hotel_id', $hotel_id)
            ->where(function ($query) use ($value_rates_plan, $value_room_type) {
                if (!empty($value_rates_plan)) {
                    $query->where('rate_plans.id', $value_rates_plan);
                }

                if (!empty($value_room_type)) {
                    $query->where('rate_plans.room_type_id', $value_room_type);
                }

            })->orderBy('rate_plans.id', 'ASC')->select('rate_plans.room_type_id')->get();
        if (isset($ratePlan) && !empty($ratePlan)) {
            foreach ($ratePlan as $key => $value) {
                array_push($ar_get_selected_root_typeID, $value->room_type_id);
            }
        }

        if (!empty($ar_get_selected_root_typeID)) {
            $ar_get_selected_root_typeID = array_unique($ar_get_selected_root_typeID);
        }

        $roomType = array();
        $roomTypeCnt = 0;

        if (!empty($ar_get_selected_root_typeID)) {
            $roomType = RoomType::where('hotel_id', $hotel_id)->whereIn('id', $ar_get_selected_root_typeID)->orderBy('room_order', 'ASC')->get();
            $roomTypeCnt = $roomType->count();
        }

        $data['roomType'] = $roomType;
        $data['roomTypeCnt'] = $roomTypeCnt;

        $availabilityData = InventoryMaster::where('hotel_id', $hotel_id)->where('date', '>=', $set_global_date)->where(function ($query) use ($value_room_type) {
            if (!empty($value_room_type)) {
                $query->where('room_type_id', $value_room_type);
            }
        })->orderBy('date', 'ASC')->get();

        $ar_inventoryMaster = array();
        if (isset($availabilityData) && !empty($availabilityData)) {
            foreach ($availabilityData as $key => $value) {

                $room_type_id = $value->room_type_id;
                $str_date = strtotime($value->date);
                $ar_inventoryMaster[$room_type_id][$str_date] = $value->availability;
            }
        }
        $data['ar_inventoryMaster'] = $ar_inventoryMaster;


        $rateMaster = RateRestrictionMaster::where('hotel_id', $hotel_id)->where('date', '>=', $set_global_date)->where(function ($query) use ($value_rates_plan, $value_room_type) {
            if (!empty($value_rates_plan)) {
                $query->where('rate_plan_id', $value_rates_plan);
            }

            if (!empty($value_room_type)) {
                $query->where('room_type_id', $value_room_type);
            }

        })->orderBy('date', 'ASC')->distinct()->get();

        $ar_rateRestrictionData = array();
        if (isset($rateMaster) && !empty($rateMaster)) {
            foreach ($rateMaster as $key => $value) {

                if (isset($value->room_type_id) && !empty($value->room_type_id)) {

                    $room_type_id = $value->room_type_id;

                    if (isset($value->rate_plan_id) && !empty($value->rate_plan_id)) {

                        $rate_plan_id = $value->rate_plan_id;

                        if (isset($value->rate_plan_id) && !empty($value->rate_plan_id)) {

                            $str_date = strtotime($value->date);

                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['base_amount'] = $value->base_amount;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['single_amount'] = $value->single_amount;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['closed'] = $value->closed;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['cta'] = $value->cta;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['ctd'] = $value->ctd;

                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['minstay'] = $value->minstay;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['maxstay'] = $value->maxstay;

                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['extra_adult_1_amount'] = $value->extra_adult_1_amount;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['extra_adult_2_amount'] = $value->extra_adult_2_amount;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['extra_adult_3_amount'] = $value->extra_adult_3_amount;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['extra_adult_4_amount'] = $value->extra_adult_4_amount;

                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['child_age_1_rate'] = $value->child_age_1_rate;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['child_age_2_rate'] = $value->child_age_2_rate;
                            $ar_rateRestrictionData[$room_type_id][$rate_plan_id][$str_date]['child_age_3_rate'] = $value->child_age_3_rate;

                            /*dd($ar_rateRestrictionData, date("d-m-Y", $str_date));*/
                        }
                    }
                }
            }
        }
        /*dd($ar_rateRestrictionData);*/
        $data['ar_rateRestrictionData'] = $ar_rateRestrictionData;

        $rateMasterCnt = $rateMaster->count();

        $data['rateMaster'] = $rateMaster;
        $data['rateMasterCnt'] = $rateMasterCnt;

        return view('admin.pages.hotel_panel.calender.ajax.index', $data);
    }


    public function manageStoreCalendarData(Request $request)
    {
        $today_date = date("Y-m-d");
        $today = date("Y-m-d H:i:s");

        $html = false;
        $data = array();
        $data_post = $request->all();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;

        if (isset($data_post['data_main_data']) && !empty($data_post['data_main_data'])) {

            $ar_main_data = array();
            $ar_main_data = $data_post['data_main_data'];
            foreach ($ar_main_data as $key => $value) {

                if (!empty($value)) {

                    foreach ($value as $a_key => $a_value) {

                        $room_type_id = $a_value['room_type_id'];
                        $availability_date = date("Y-m-d", strtotime($a_value['date']));

                        $logs_value_data = array();
                        if ($key == "inventory") {

                            $availability = 0;
                            if (isset($a_value['value']) && !empty($a_value['value'])) {
                                $availability = $a_value['value'];
                            }

                            $update_ar = array();
                            $update_ar['hotel_id'] = $hotel_id;
                            $update_ar['room_type_id'] = $room_type_id;
                            $update_ar['date'] = $availability_date;
                            $update_ar['availability'] = $availability;

                            $pre_availability = 0;
                            $checkExist = array();
                            $checkExist = InventoryMaster::where('hotel_id', '=', $hotel_id)->where('room_type_id', '=', $room_type_id)->whereDate('date', '=', $availability_date)->orderBy('date', 'ASC')->first();
                            if (isset($checkExist) && !empty($checkExist)) {

                                $pre_availability = $checkExist->availability;

                                $html = true;
                                $update_ar['updated_at'] = $today;

                                InventoryMaster::where('id', $checkExist->id)->update($update_ar);

                            } else {
                                $html = true;
                                $update_ar['created_at'] = $today;
                                InventoryMaster::insert($update_ar);
                            }

                            /****************************************************************************************************************************/

                            $ar_value_data = array();
                            $ar_value_data['updated_from'] = "Calendar";
                            $ar_value_data['type'] = "inventory";
                            $ar_value_data['update_type'] = "availability";
                            $ar_value_data['old_value'] = $pre_availability;
                            $ar_value_data['new_value'] = $availability;
                            $ar_value_data['updated_date'] = $today;
                            $ar_value_data['ip_address'] = $this->getIpAddress();

                            $logs_value_data[] = $ar_value_data;

                            $ar_logData = array();
                            $ar_logData['hotel_id'] = $hotel_id;
                            $ar_logData['room_type_id'] = $room_type_id;
                            $ar_logData['rate_plan_id'] = 0;
                            $ar_logData['date'] = $availability_date;

                            $checkExists = array();
                            $checkExists = Logs::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->whereDate('date', $availability_date)->first();
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

                        }

                        if ($key != "inventory") {

                            $rate_plan_id = $a_value['rate_plan_id'];

                            $update_ar = array();
                            $update_ar['hotel_id'] = $hotel_id;
                            $update_ar['room_type_id'] = $room_type_id;
                            $update_ar['rate_plan_id'] = $rate_plan_id;
                            $update_ar['date'] = $availability_date;

                            $old_value = 0;
                            $new_value = 0;
                            $update_type = "";
                            if ($key == "restriction_close") {

                                $update_ar['closed'] = $a_value['value'];
                                $new_value = $update_ar['closed'];

                                $update_type = "closed";
                            }
                            if ($key == "restriction_cta") {

                                $update_ar['cta'] = $a_value['value'];
                                $new_value = $update_ar['cta'];

                                $update_type = "cta";
                            }
                            if ($key == "restriction_ctd") {

                                $update_ar['ctd'] = $a_value['value'];
                                $new_value = $update_ar['ctd'];

                                $update_type = "ctd";
                            }

                            if ($key == "restriction_base_amount") {

                                $update_ar['base_amount'] = $a_value['value'];
                                $new_value = $update_ar['base_amount'];

                                $update_type = "rate";
                            }

                            if ($key == "restriction_min_stay") {

                                $update_ar['minstay'] = $a_value['value'];
                                $new_value = $update_ar['minstay'];

                                $update_type = "minstay";
                            }

                            if ($key == "restriction_max_stay") {

                                $update_ar['maxstay'] = $a_value['value'];
                                $new_value = $update_ar['maxstay'];

                                $update_type = "maxstay";
                            }

                            if ($key == "restriction_single_amount") {

                                $update_ar['single_amount'] = $a_value['value'];
                                $new_value = $update_ar['single_amount'];

                                $update_type = "single_rate";
                            }

                            /**********************************************************************************************************/
                            if ($key == "restriction_ext_adult1_amount") {

                                $update_ar['extra_adult_1_amount'] = $a_value['value'];
                                $new_value = $update_ar['extra_adult_1_amount'];

                                $update_type = "ext_adult1_rate";
                            }

                            if ($key == "restriction_ext_adult2_amount") {

                                $update_ar['extra_adult_2_amount'] = $a_value['value'];
                                $new_value = $update_ar['extra_adult_2_amount'];

                                $update_type = "ext_adult2_rate";
                            }

                            if ($key == "restriction_ext_adult3_amount") {

                                $update_ar['extra_adult_3_amount'] = $a_value['value'];
                                $new_value = $update_ar['extra_adult_3_amount'];

                                $update_type = "ext_adult3_rate";
                            }

                            if ($key == "restriction_ext_adult4_amount") {

                                $update_ar['extra_adult_4_amount'] = $a_value['value'];
                                $new_value = $update_ar['extra_adult_4_amount'];

                                $update_type = "ext_adult4_rate";
                            }

                            /**********************************************************************************************************/

                            if ($key == "restriction_child_age1_rate") {

                                $update_ar['child_age_1_rate'] = $a_value['value'];
                                $new_value = $update_ar['child_age_1_rate'];

                                $update_type = "child_age1_rate";
                            }

                            if ($key == "restriction_child_age2_rate") {

                                $update_ar['child_age_2_rate'] = $a_value['value'];
                                $new_value = $update_ar['child_age_2_rate'];

                                $update_type = "child_age2_rate";
                            }

                            if ($key == "restriction_child_age3_rate") {

                                $update_ar['child_age_3_rate'] = $a_value['value'];
                                $new_value = $update_ar['child_age_3_rate'];

                                $update_type = "child_age3_rate";
                            }

                            /**********************************************************************************************************/

                            $checkExist = array();
                            $checkExist = RateRestrictionMaster::where('hotel_id', '=', $hotel_id)->where('room_type_id', '=', $room_type_id)->where('rate_plan_id', '=', $rate_plan_id)
                                ->whereDate('date', '=', $availability_date)
                                ->orderBy('date', 'ASC')->first();
                            if (isset($checkExist) && !empty($checkExist)) {

                                if ($key == "restriction_close") {
                                    $old_value = $checkExist->closed;
                                }

                                if ($key == "restriction_cta") {
                                    $old_value = $checkExist->cta;
                                }

                                if ($key == "restriction_ctd") {
                                    $old_value = $checkExist->ctd;
                                }

                                if ($key == "restriction_base_amount") {
                                    $old_value = $checkExist->base_amount;
                                }

                                if ($key == "restriction_min_stay") {
                                    $old_value = $checkExist->minstay;
                                }

                                if ($key == "restriction_max_stay") {
                                    $old_value = $checkExist->maxstay;
                                }

                                if ($key == "restriction_single_amount") {
                                    $old_value = $checkExist->single_amount;
                                }

                                if ($key == "restriction_ext_adult1_amount") {
                                    $old_value = $checkExist->extra_adult_1_amount;
                                }

                                if ($key == "restriction_ext_adult2_amount") {
                                    $old_value = $checkExist->extra_adult_2_amount;
                                }

                                if ($key == "restriction_ext_adult3_amount") {
                                    $old_value = $checkExist->extra_adult_3_amount;
                                }

                                if ($key == "restriction_ext_adult4_amount") {
                                    $old_value = $checkExist->extra_adult_4_amount;
                                }

                                if ($key == "restriction_child_age1_rate") {
                                    $old_value = $checkExist->child_age_1_rate;
                                }

                                if ($key == "restriction_child_age2_rate") {
                                    $old_value = $checkExist->child_age_2_rate;
                                }

                                if ($key == "restriction_child_age3_rate") {
                                    $old_value = $checkExist->child_age_3_rate;
                                }

                                $html = true;
                                $update_ar['updated_at'] = $today;
                                RateRestrictionMaster::where('id', $checkExist->id)->update($update_ar);

                            } else {

                                $html = true;
                                $update_ar['created_at'] = $today;
                                RateRestrictionMaster::insert($update_ar);
                            }

                            $ar_value_data = array();
                            $ar_value_data['updated_from'] = "Calendar";
                            $ar_value_data['type'] = "restriction";
                            $ar_value_data['update_type'] = $update_type;
                            $ar_value_data['old_value'] = $old_value;
                            $ar_value_data['new_value'] = $new_value;
                            $ar_value_data['updated_date'] = $today;
                            $ar_value_data['ip_address'] = $this->getIpAddress();

                            $logs_value_data[] = $ar_value_data;

                            /**********************************************************************************************************/

                            $ar_logData = array();
                            $ar_logData['hotel_id'] = $hotel_id;
                            $ar_logData['room_type_id'] = $room_type_id;
                            $ar_logData['rate_plan_id'] = $rate_plan_id;
                            $ar_logData['date'] = $availability_date;

                            $checkExists = array();
                            $checkExists = Logs::where('hotel_id', $hotel_id)->where('room_type_id', $room_type_id)->whereDate('date', $availability_date)->first();
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
                        }
                    }
                }
            }
        }

        echo $html;
        exit;
    }

    /*******************************************************************************************************/

    public function delete($id)
    {
        $Currency = InventoryMaster::where(['id' => $id])->first();
        $Currency->delete();
        return redirect()->back()->with('success', 'calendar successfully deleted');
    }
}
