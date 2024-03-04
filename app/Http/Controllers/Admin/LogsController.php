<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\heplers\helper;
use Auth;
use Str;
use App\Models\Logs;
use App\Models\RoomType;
use App\Models\RateType;
use App\Models\RatePlan;

class LogsController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $data['hotel_id'] = $hotel_id;

        $roomType = RoomType::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->get();
        $data['roomTypeData'] = $roomType;

        $rateType = RateType::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->get();
        $data['rateTypeData'] = $rateType;

        $ratePlan = RatePlan::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->get();
        $data['ratePlanData'] = $ratePlan;

        return view('admin.pages.hotel_panel.logs.index', $data);
    }

    public function dataList(Request $request)
    {
        $data = array();
        $data_post = $request->all();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $data['hotel_id'] = $hotel_id;

        $room_type_id = 0;
        $rate_plan_id = 0;

        if (isset($data_post['data_room_type_id']) && !empty($data_post['data_room_type_id'])) {
            $room_type_id = $data_post['data_room_type_id'];
        }

        if (isset($data_post['data_rate_plan_id']) && !empty($data_post['data_rate_plan_id'])) {
            $rate_plan_id = $data_post['data_rate_plan_id'];
        }

        $resultData = array();
        if (isset($data_post['data_from_date_input_date']) && !empty($data_post['data_from_date_input_date'])) {

            if (isset($data_post['data_to_date_input_date']) && !empty($data_post['data_to_date_input_date'])) {

                $form_date = date("Y-m-d", strtotime($data_post['data_from_date_input_date']));
                $to_date = date("Y-m-d", strtotime($data_post['data_to_date_input_date']));

                $resultData = Logs::where('hotel_id', $hotel_id)->whereDate('date', '>=', $form_date)->whereDate('date', '<=', $to_date)
                    ->where(function ($query) use ($room_type_id, $rate_plan_id) {

                        if (!empty($room_type_id)) {
                            $query->where('room_type_id', $room_type_id);
                        }

                        if (!empty($rate_plan_id)) {
                            $query->where('rate_plan_id', $rate_plan_id);
                        }
                    })->orderBy('date', 'ASC')->get();
            }
        }
        $data['resultData'] = $resultData;

        return view('admin.pages.hotel_panel.logs.ajax.index', $data);
    }

    public function logsDetails(Request $request, $id = null)
    {
        $data = array();
        if (!empty($id)) {

            $id = base64_decode($id);
            $hotel_id = Auth::guard('admin')->user()->hotel_id;
            $data['hotel_id'] = $hotel_id;

            $resultData = array();
            $resultData = Logs::where('hotel_id', $hotel_id)->where('id', $id)->orderBy('date', 'ASC')->first();
            if (isset($resultData) && !empty($resultData)) {
                $data['resultData'] = $resultData;
                return view('admin.pages.hotel_panel.logs.ajax.details', $data);
            }
        }

        return redirect()->route('admin.hotel.logs');
    }
}