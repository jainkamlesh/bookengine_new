<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Offer;
use App\Models\RatePlan;
use App\heplers\helper;
use Auth;
use Str;

class OfferController extends Controller
{
    public function index()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $offer = Offer::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->Paginate(10);
        $offerCnt = $offer->count();
        $data = compact('offer', 'offerCnt');

        return view('admin.pages.hotel_panel.offer.index', $data);
    }

    public function add()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $rate_plan = RatePlan::where('hotel_id', $hotel_id)->get();
        $rate_planCnt = $rate_plan->count();

        $data = compact('rate_plan', 'rate_planCnt');
        return view('admin.pages.hotel_panel.offer.add_offer', $data);
    }

    public function edit($id)
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $offer = Offer::where(['id' => $id])->first();
        $rate_plan = RatePlan::where('hotel_id', $hotel_id)->get();
        $rate_planCnt = $rate_plan->count();
        $data = compact('offer', 'rate_plan', 'rate_planCnt');
        return view('admin.pages.hotel_panel.offer.edit_offer', $data);
    }

    public function br2nl($string){
        return preg_replace('#<br\s*/?>#i', "", $string);
    }

    public function store(request $request)
    {
        if ($request->isMethod('post')) {

            if (!empty($request->id)) {
                $rules = array(
                    'name' => 'required',
                    'description' => 'required',
                    'valid_from' => 'required',
                    'valid_to' => 'required',
                    'discount_percentage' => 'required',
                );
            } else {
                $rules = array(
                    'name' => 'required',
                    'image' => 'required',
                    'description' => 'required',
                    'valid_from' => 'required',
                    'valid_to' => 'required',
                    'discount_percentage' => 'required',
                );
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $offer = Offer::where(['id' => $request->id])->first();
        if (empty($offer)) {
            $offer = new Offer;
        }

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $offer->hotel_id = $hotel_id;

        if (isset($request->no_of_adults)) {
            $offer->min_no_of_adults = $request->min_no_of_adults;
            $offer->max_no_of_adults = $request->max_no_of_adults;
        } else {
            $offer->min_no_of_adults = NULL;
            $offer->max_no_of_adults = NULL;
        }

        if (isset($request->no_of_child)) {
            $offer->min_no_of_child = $request->min_no_of_child;
            $offer->max_no_of_child = $request->max_no_of_child;

        } else {
            $offer->min_no_of_child = NULL;
            $offer->max_no_of_child = NULL;
        }

        if (isset($request->days_in_advance)) {
            $offer->min_days_in_advance = $request->min_days_in_advance;
            $offer->max_days_in_advance = $request->max_days_in_advance;
        } else {
            $offer->min_days_in_advance = NULL;
            $offer->max_days_in_advance = NULL;
        }

        if (isset($request->no_of_night)) {
            $offer->min_no_of_night = $request->min_no_of_night;
            $offer->max_no_of_night = $request->max_no_of_night;

        } else {
            $offer->min_no_of_night = NULL;
            $offer->max_no_of_night = NULL;
        }

        if ($request->file('image') != '') {
            $image_path = url('public/images/offer/' . $request->image);

            if (file_exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = time() . '_offer' . '.' . request()->image->guessClientExtension();
            $upload_path = 'public/images/offer/';

            request()->image->move($upload_path, $imageName);
            $offer->image = $imageName;
        }

        // exclusive_days array
        $exclusive_days_arr = array();
        $exclusive_days = $request->exclusive_days;
        if (!empty($exclusive_days)) {
            foreach ($exclusive_days as $key => $value) {
                if ( isset($value) && $value != '' ) {
                    $exclusive_days_arr[$key]['exclusive_days'] = $value;
                }
            }
        }

        //room_list array
        $room_list_arr = array();
        $room_list = $request->room_list;
        if (!empty($room_list)) {
            foreach ($room_list as $key => $value) {
                $room_list_arr[$key]['room_list'] = $value;
            }
        }

        //days_of_week array
        $days_of_week_arr = array();
        $days_of_week = $request->days_of_week;
        if (!empty($days_of_week)) {
            foreach ($days_of_week as $key => $value) {
                $days_of_week_arr[$key]['days_of_week'] = $value;
            }
        }

        $offer->name = $request->name;
        $offer->name_it = $request->name_it;
        $offer->name_fr = $request->name_fr;
        $offer->name_es = $request->name_es;
        $offer->name_de = $request->name_de;

        $offer->description = nl2br(self::br2nl($request->description));
        $offer->description_it = nl2br(self::br2nl($request->description_it));
        $offer->description_es = nl2br(self::br2nl($request->description_es));
        $offer->description_fr = nl2br(self::br2nl($request->description_fr));
        $offer->description_de = nl2br(self::br2nl($request->description_de));

        $offer->valid_from = $request->valid_from;
        $offer->valid_to = $request->valid_to;
        $offer->discount_percentage = $request->discount_percentage;
        $offer->mobile_offer = $request->mobile_offer;

        // array parameter
        $offer->days_of_week = json_encode($days_of_week_arr);
        $offer->room_list = json_encode($room_list_arr);
        $offer->exclusive_days = json_encode($exclusive_days_arr);

        $offer->save();

        return redirect()->back()->with('success', 'offer successfully uploaded');
    }

    public function delete($id)
    {
        $offer = Offer::where(['id' => $id])->first();
        $offer->delete();
        return redirect()->back()->with('success', 'offer successfully deleted');
    }
}
