<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\RequestBooking;
use GuzzleHttp\Client;
use App\Models\Hotel;
use Excel;
use App\Imports\RequestImport;
class RequestBookingController extends Controller
{
    public function index(Request $request)
    {
        $data = array();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;

        $totalData = RequestBooking::where('hotel_id', $hotel_id)->count();
        $data['totalData'] = $totalData;

        return view('admin.pages.hotel_panel.booking_request.index', $data);
    }

    public function listData(Request $request)
    {
        $data = array();
        $data_post = $request->all();

        $skip = $data_post['data_skip'];
        $per_page = $data_post['data_per_page'];

        $hotel_id = Auth::guard('admin')->user()->hotel_id;

        $resultData = RequestBooking::where('hotel_id', $hotel_id)->where(function ($query) use ($data_post) {

            if (isset($data_post['data_select_search_by']) && !empty($data_post['data_select_search_by'])) {

                $select_search_by = $data_post['data_select_search_by'];

                $from_date = $to_date = "";
                if (isset($data_post['data_from_date']) && !empty($data_post['data_from_date'])) {

                    $from_date = date("Y-m-d", strtotime($data_post['data_from_date']));
                }

                if (isset($data_post['data_to_date']) && !empty($data_post['data_to_date'])) {

                    $to_date = date("Y-m-d", strtotime($data_post['data_to_date']));
                }

                if (isset($from_date) && !empty($from_date) && isset($to_date) && !empty($to_date)) {

                    if ($select_search_by == "booking_date") {

                        $query->whereBetween('created_at', [$from_date, $to_date]);

                    } if ($select_search_by == "check_in") {

                        $query->whereBetween('check_in', [$from_date, $to_date]);

                    } if ($select_search_by == "check_out") {

                        $query->whereBetween('check_out', [$from_date, $to_date]);
                    }
                }
            }
        });

        $resultData = $resultData->orderBy('id', 'DESC')->offset($skip)->limit($per_page)->get();

        $data['resultData'] = $resultData;

        ##hotel detail
        $hotelDetail = Hotel::where(['id' => $hotel_id])->first();
        $data['hotelDetail'] = $hotelDetail;

        return view('admin.pages.hotel_panel.booking_request.ajax.index', $data);
    }


    public function requestsUpload(Request $request)
    {
        if($request->hasFile('bulk_file')){
            Excel::import(new RequestImport, request()->file('bulk_file'));
        }else{
            return redirect()->back()->with('error', 'Please Select Excel File');
        }
        return redirect()->back()->with('success', 'Excel Uploaded Successfully');
    }
}
