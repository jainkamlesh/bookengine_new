<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;
use App\heplers\helper;
use Auth;
use Str;

class CouponController extends Controller
{
    public function index()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $coupon = Coupon::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->Paginate(10);
        $couponCnt = $coupon->count();
        $data = compact('coupon', 'couponCnt');

        return view('admin.pages.hotel_panel.coupon.index', $data);
    }

    public function add()
    {
        return view('admin.pages.hotel_panel.coupon.add_coupon');
    }

    public function edit($id)
    {
        $coupon = Coupon::where(['id' => $id])->first();
        $data = compact('coupon');
        return view('admin.pages.hotel_panel.coupon.edit_coupon', $data);
    }


    public function store(request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'code' => 'required',
                'valid_from' => 'required',
                'valid_to' => 'required',
                'discount_percentage' => 'required',
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $coupon = Coupon::where(['id' => $request->id])->first();
        if (empty($coupon)) {
            $coupon = new Coupon;
        }

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $coupon->code = $request->code;
        $coupon->valid_from = $request->valid_from;
        $coupon->valid_to = $request->valid_to;
        $coupon->discount_percentage = $request->discount_percentage;
        $coupon->fixed_discount = $request->fixed_discount;
        $coupon->hotel_id = $hotel_id;
        $coupon->save();

        return redirect()->back()->with('success', 'coupon successfully uploaded');
    }

    public function delete($id)
    {
        $coupon = Coupon::where(['id' => $id])->first();
        $coupon->delete();
        return redirect()->back()->with('success', 'coupon successfully deleted');
    }
}
