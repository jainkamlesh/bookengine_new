<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RatePlan;
use App\Models\RateType;
use App\Models\RoomType;
use App\heplers\helper;
use Auth;
use Str;
use Storage;

class RatePlanController extends Controller
{
    public function index()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $ratePlan = RatePlan::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->Paginate(100);
        $ratePlanCnt = $ratePlan->count();

        $roomType = RoomType::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->pluck('name', 'id')->toArray();
        $rateType = RateType::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->pluck('name', 'id')->toArray();

        $data = compact('ratePlan', 'ratePlanCnt', 'roomType', 'rateType');

        return view('admin.pages.hotel_panel.rate_plan.index', $data);
    }

    public function add()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $roomType = RoomType::where('hotel_id', $hotel_id)->get();
        $rateType = RateType::where('hotel_id', $hotel_id)->get();
        $roomTypeCnt = $roomType->count();
        $rateTypeCnt = $rateType->count();

        $data = compact('roomType', 'roomTypeCnt', 'rateType', 'rateTypeCnt');
        return view('admin.pages.hotel_panel.rate_plan.add_rate_plan', $data);
    }

    public function edit($id)
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $roomType = RoomType::where('hotel_id', $hotel_id)->get();
        $rateType = RateType::where('hotel_id', $hotel_id)->get();
        $roomTypeCnt = $roomType->count();
        $rateTypeCnt = $rateType->count();

        $ratePlan = RatePlan::where(['id' => $id])->first();
        $data = compact('ratePlan', 'roomType', 'roomTypeCnt', 'rateType', 'rateTypeCnt');
        return view('admin.pages.hotel_panel.rate_plan.edit_rate_plan', $data);
    }

    public function br2nl($string){
        return preg_replace('#<br\s*/?>#i', "", $string);
    }

    public function store(request $request)
    {
        if ($request->isMethod('post')) {

            $rules = array(
                'name' => 'required',
                'room_type_id' => 'required',
                'rate_type_id' => 'required',
                'room_price' => 'required',
                /*'ext_adult1_rate' => 'required',
                'ext_adult2_rate' => 'required',
                'ext_adult3_rate' => 'required',
                'ext_adult4_rate' => 'required',
                'child_age1_rate' => 'required',
                'child_age2_rate' => 'required',
                'child_age3_rate' => 'required',*/
                'min_nights' => 'required',
                'max_nights' => 'required',
                /*'single_stay' => 'required',
                'single_price' => 'required',*/
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $ratePlan = RatePlan::where(['id' => $request->id])->first();
            if (empty($ratePlan)) {
                $ratePlan = new RatePlan;
            }

            $hotel_id = Auth::guard('admin')->user()->hotel_id;

            $ratePlan->hotel_id = $hotel_id;
            $ratePlan->name = $request->name;
            $ratePlan->name_it = $request->name_it;
            $ratePlan->name_de = $request->name_de;
            $ratePlan->name_fr = $request->name_fr;
            $ratePlan->name_es = $request->name_es;

            $ratePlan->room_type_id = $request->room_type_id;
            $ratePlan->rate_type_id = $request->rate_type_id;

            $ratePlan->room_price = $request->room_price;

            $ratePlan->child_age1_rate = $request->child_age1_rate;
            $ratePlan->child_age2_rate = $request->child_age2_rate;
            $ratePlan->child_age3_rate = $request->child_age3_rate;

            $ratePlan->child_age1_rate_plus = $request->child_age1_rate_plus;
            $ratePlan->child_age2_rate_plus = $request->child_age2_rate_plus;
            $ratePlan->child_age3_rate_plus = $request->child_age3_rate_plus;

            $ratePlan->child_age1_rate_percentage = $request->child_age1_rate_percentage;
            $ratePlan->child_age2_rate_percentage = $request->child_age2_rate_percentage;
            $ratePlan->child_age3_rate_percentage = $request->child_age3_rate_percentage;

            $ratePlan->ext_adult1_rate = $request->ext_adult1_rate;
            $ratePlan->ext_adult2_rate = $request->ext_adult2_rate;
            $ratePlan->ext_adult3_rate = $request->ext_adult3_rate;
            $ratePlan->ext_adult4_rate = $request->ext_adult4_rate;

            $ratePlan->ext_adult1_rate_plus = $request->ext_adult1_rate_plus;
            $ratePlan->ext_adult2_rate_plus = $request->ext_adult2_rate_plus;
            $ratePlan->ext_adult3_rate_plus = $request->ext_adult3_rate_plus;
            $ratePlan->ext_adult4_rate_plus = $request->ext_adult4_rate_plus;

            $ratePlan->ext_adult1_rate_percentage = $request->ext_adult1_rate_percentage;
            $ratePlan->ext_adult2_rate_percentage = $request->ext_adult2_rate_percentage;
            $ratePlan->ext_adult3_rate_percentage = $request->ext_adult3_rate_percentage;
            $ratePlan->ext_adult4_rate_percentage = $request->ext_adult4_rate_percentage;

            $ratePlan->min_nights = $request->min_nights;
            $ratePlan->max_nights = $request->max_nights;

            $ratePlan->single_stay = $request->single_stay;
            $ratePlan->single_price = $request->single_price;
            $ratePlan->cc_required = $request->cc_required;
            
            $ratePlan->booking_condition    = nl2br(self::br2nl($request->booking_condition));
            $ratePlan->booking_condition_it = nl2br(self::br2nl($request->booking_condition_it));
            $ratePlan->booking_condition_de = nl2br(self::br2nl($request->booking_condition_de));
            $ratePlan->booking_condition_es = nl2br(self::br2nl($request->booking_condition_es));
            $ratePlan->booking_condition_fr = nl2br(self::br2nl($request->booking_condition_fr));

            $ratePlan->is_master = $request->is_master;
            $ratePlan->derived_percentage = $request->derived_percentage;
            if ( isset($request->master_plan_id) && $request->master_plan_id > 0 ) {
                $ratePlan->master_plan_id = $request->master_plan_id;
            }
            else {
                $ratePlan->master_plan_id = 0;
            }

            $ratePlan->save();

            $ratePlan_id = $ratePlan->id;
            $string = "RatePlan_".$hotel_id."_".$request->room_type_id."_".$request->rate_type_id."_".$ratePlan_id;

            $rand_number = floor(microtime(true) * 1000);
            $file_name = "RatePlan/".$rand_number.".txt";
            Storage::disk('public')->put($file_name, $string);

            return redirect()->back()->with('success', 'Room Plan successfully uploaded');
        }

        return redirect()->back();
    }

    public function derived_store(request $request)
    {
        if ($request->isMethod('post')) {

            $rules = array(
                'name' => 'required',
                'master_plan_id' => 'required',
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $existing_plan = RatePlan::where(['id' => $request->master_plan_id])->first();

            $ratePlan = new RatePlan;
            
            $hotel_id = Auth::guard('admin')->user()->hotel_id;

            $ratePlan->hotel_id = $hotel_id;
            $ratePlan->name = $request->name;
            $ratePlan->name_it = $request->name_it;
            $ratePlan->name_de = $request->name_de;
            $ratePlan->name_fr = $request->name_fr;
            $ratePlan->name_es = $request->name_es;

            $ratePlan->room_type_id = $existing_plan->room_type_id;
            $ratePlan->rate_type_id = $existing_plan->rate_type_id;

            $ratePlan->room_price = $existing_plan->room_price;

            $ratePlan->child_age1_rate = $existing_plan->child_age1_rate;
            $ratePlan->child_age2_rate = $existing_plan->child_age2_rate;
            $ratePlan->child_age3_rate = $existing_plan->child_age3_rate;

            $ratePlan->child_age1_rate_plus = $request->child_age1_rate_plus;
            $ratePlan->child_age2_rate_plus = $request->child_age2_rate_plus;
            $ratePlan->child_age3_rate_plus = $request->child_age3_rate_plus;

            $ratePlan->child_age1_rate_percentage = $request->child_age1_rate_percentage;
            $ratePlan->child_age2_rate_percentage = $request->child_age2_rate_percentage;
            $ratePlan->child_age3_rate_percentage = $request->child_age3_rate_percentage;

            $ratePlan->ext_adult1_rate = $existing_plan->ext_adult1_rate;
            $ratePlan->ext_adult2_rate = $existing_plan->ext_adult2_rate;
            $ratePlan->ext_adult3_rate = $existing_plan->ext_adult3_rate;
            $ratePlan->ext_adult4_rate = $existing_plan->ext_adult4_rate;

            $ratePlan->ext_adult1_rate_plus = $request->ext_adult1_rate_plus;
            $ratePlan->ext_adult2_rate_plus = $request->ext_adult2_rate_plus;
            $ratePlan->ext_adult3_rate_plus = $request->ext_adult3_rate_plus;
            $ratePlan->ext_adult4_rate_plus = $request->ext_adult4_rate_plus;

            $ratePlan->ext_adult1_rate_percentage = $request->ext_adult1_rate_percentage;
            $ratePlan->ext_adult2_rate_percentage = $request->ext_adult2_rate_percentage;
            $ratePlan->ext_adult3_rate_percentage = $request->ext_adult3_rate_percentage;
            $ratePlan->ext_adult4_rate_percentage = $request->ext_adult4_rate_percentage;
            
            $ratePlan->min_nights = $existing_plan->min_nights;
            $ratePlan->max_nights = $existing_plan->max_nights;

            $ratePlan->single_stay = $existing_plan->single_stay;
            $ratePlan->single_price = $existing_plan->single_price;
            $ratePlan->cc_required = $existing_plan->cc_required;
            
            $ratePlan->booking_condition    = nl2br(self::br2nl($existing_plan->booking_condition));
            $ratePlan->booking_condition_it = nl2br(self::br2nl($existing_plan->booking_condition_it));
            $ratePlan->booking_condition_de = nl2br(self::br2nl($existing_plan->booking_condition_de));
            $ratePlan->booking_condition_es = nl2br(self::br2nl($existing_plan->booking_condition_es));
            $ratePlan->booking_condition_fr = nl2br(self::br2nl($existing_plan->booking_condition_fr));

            $ratePlan->is_master = 0;
            $ratePlan->derived_percentage = $request->derived_percentage;
            $ratePlan->master_plan_id = $request->master_plan_id;

            $ratePlan->save();

            $ratePlan_id = $ratePlan->id;
            $string = "RatePlan_".$hotel_id."_".$request->room_type_id."_".$request->rate_type_id."_".$ratePlan_id;

            $rand_number = floor(microtime(true) * 1000);
            $file_name = "RatePlan/".$rand_number.".txt";
            Storage::disk('public')->put($file_name, $string);

            return redirect()->back()->with('success', 'Room Plan successfully uploaded');
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        $ratePlan = RatePlan::where(['id' => $id])->first();
        $ratePlan->delete();
        return redirect()->back()->with('success', 'Room Plan successfully deleted');
    }
}
