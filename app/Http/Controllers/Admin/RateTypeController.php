<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RateType;
use App\heplers\helper;
use Auth;
use Str;
use Storage;

class RateTypeController extends Controller
{
    public function index()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $rateType = RateType::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->Paginate(10);
        $rateTypeCnt = $rateType->count();
        $data = compact('rateType', 'rateTypeCnt');

        return view('admin.pages.hotel_panel.rate_type.index', $data);
    }

    public function add()
    {
        return view('admin.pages.hotel_panel.rate_type.add_rate_type');
    }

    public function edit($id)
    {
        $rateType = RateType::where(['id' => $id])->first();
        $data = compact('rateType');
        return view('admin.pages.hotel_panel.rate_type.edit_rate_type', $data);
    }
    
    public function br2nl($string){
        return preg_replace('#<br\s*/?>#i', "", $string);
    }

    public function store(request $request)
    {
        if ($request->isMethod('post')) {
            if (empty($request->id)) {
                $rules = array(
                    'name' => 'required',
                    /*'short_description' => 'required',
                    'cancellation_condition' => 'required',
                    'is_refundable' => 'required',
                    'deposit_percentage' => 'required',*/

                );
            } else {
                $rules = array(
                    'name' => 'required',
                    /*'short_description' => 'required',
                    'cancellation_condition' => 'required',
                    'is_refundable' => 'required',
                    'deposit_percentage' => 'required',*/
                );
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $is_exist = 1;
        $rateType = RateType::where(['id' => $request->id])->first();
        if (empty($rateType)) {
            $rateType = new RateType;
            $is_exist = 0;
        }

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $rateType->name = $request->name;
        $rateType->short_description = nl2br(self::br2nl($request->short_description));
          $rateType->cancellation_condition = nl2br(self::br2nl($request->cancellation_condition));
        $rateType->is_refundable = $request->is_refundable;
        $rateType->hotel_id = $hotel_id;
        $rateType->deposit_percentage = $request->deposit_percentage;
        $rateType->cancellation_days = $request->cancellation_days;

        $rateType->name_it = $request->name_it;
        $rateType->short_description_it = nl2br(self::br2nl($request->short_description_it));
          $rateType->cancellation_condition_it = nl2br(self::br2nl($request->cancellation_condition_it));

        $rateType->name_fr = $request->name_fr;
        $rateType->short_description_fr = nl2br(self::br2nl($request->short_description_fr));
          $rateType->cancellation_condition_fr = nl2br(self::br2nl($request->cancellation_condition_fr));

        $rateType->name_de = $request->name_de;
        $rateType->short_description_de = nl2br(self::br2nl($request->short_description_de));
          $rateType->cancellation_condition_de = nl2br(self::br2nl($request->cancellation_condition_de));

        $rateType->name_es = $request->name_es;
        $rateType->short_description_es = nl2br(self::br2nl($request->short_description_es));
          $rateType->cancellation_condition_es = nl2br(self::br2nl($request->cancellation_condition_es));

        $rateType->save();

        if ( $is_exist ) {
            $rateType_id = $rateType->id;
            $string = "RateType_".$hotel_id."_0_".$rateType_id."_0";

            $rand_number = floor(microtime(true) * 1000);
            $file_name = "RatePlan/".$rand_number.".txt";
            Storage::disk('public')->put($file_name, $string);
        }

        return redirect()->back()->with('success', 'Rate Type successfully uploaded');
    }

    public function delete($id)
    {
        $rateType = RateType::where(['id' => $id])->first();
        $rateType->delete();
        return redirect()->back()->with('success', 'Rate Type successfully deleted');
    }
}
