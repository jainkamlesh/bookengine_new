<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use Auth;
use Str;
use File;
use GuzzleHttp\Client;

class ServiceBookingController extends Controller
{
    public function index(Request $request)
    {
        $data = array();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;

        $totalData = ServiceBooking::where('hotel_id', $hotel_id)->count();
        $data['totalData'] = $totalData;

        return view('admin.pages.hotel_panel.service-booking.index', $data);
    }

    public function listData(Request $request)
    {
        $data = array();
        $data_post = $request->all();

        $skip = $data_post['data_skip'];
        $per_page = $data_post['data_per_page'];

        $hotel_id = Auth::guard('admin')->user()->hotel_id;

        $resultData = ServiceBooking::where('hotel_id', $hotel_id);

        $resultData = $resultData->orderBy('id', 'DESC')->offset($skip)->limit($per_page)->get();

        $data['resultData'] = $resultData;

        return view('admin.pages.hotel_panel.service-booking.ajax.index', $data);
    }

    public function detail(Request $request, $id)
    {
        $data = array();

        if(isset($id) && !empty($id)) {

            $hotel_id = Auth::guard('admin')->user()->hotel_id;

            $resultData = array();
            $resultData = ServiceBooking::where('hotel_id', $hotel_id)->where('id', $id)->first();

            if(isset($resultData) && !empty($resultData)) {

                $data['resultData'] = $resultData;

                if ( isset($resultData['tt1']) ) {
                    $booking_ref_id = $resultData['id'];
                    $email = $resultData['email'];

                    $s1 = 1540;
                    $s2 = 340;
                    $booking_ref_id = $s1 * $booking_ref_id * $s2;

                    $client = new Client();
                    $URI = 'https://www.booking-engine.it/Scripts/dd_dec.pl?booking_ref_id='.$booking_ref_id.'&email='.$email;
                    $request = $client->get($URI);
                    $response = $request->getBody();

                    $d = json_decode($response, true);

                    $resultData['numbers'] = $d['dstr1'];
                    $resultData['category_code'] = $d['dstr2'];
                }

                $selected_services_json = $resultData['selected_services'];
                $selected_services = json_decode($selected_services_json);
                $data['selected_services'] = $selected_services;
                
                return view('admin.pages.hotel_panel.service-booking.view_reservation', $data);
            }
        }
        return redirect()->back()->with('success', 'Service Details');
    }
}
