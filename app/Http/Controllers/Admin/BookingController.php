<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\heplers\helper;
use Auth;
use Str;
use File;
use App\Models\RoomType;
use App\Models\RoomFacility;
use App\Models\Booking;
use GuzzleHttp\Client;
use App\Models\Hotel;
use App\Models\WhatsappTemplate;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $data = array();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;

        $totalData = Booking::where('hotel_id', $hotel_id)->count();
        $data['totalData'] = $totalData;

        return view('admin.pages.hotel_panel.booking.index', $data);
    }

    public function listData(Request $request)
    {
        $data = array();
        $data_post = $request->all();

        $skip = $data_post['data_skip'];
        $per_page = $data_post['data_per_page'];

        $hotel_id = Auth::guard('admin')->user()->hotel_id;

        $resultData = Booking::where('hotel_id', $hotel_id)->where(function ($query) use ($data_post) {

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

                        $query->whereBetween('create_date', [$from_date, $to_date]);

                    } if ($select_search_by == "check_in") {

                        $query->whereBetween('check_in_date', [$from_date, $to_date]);

                    } if ($select_search_by == "check_out") {

                        $query->whereBetween('check_out_date', [$from_date, $to_date]);
                    }
                }
            }
        });

        $resultData = $resultData->orderBy('id', 'DESC')->offset($skip)->limit($per_page)->get();

        $data['resultData'] = $resultData;

        ##hotel detail
        $hotelDetail = Hotel::where(['id' => $hotel_id])->first();
        $data['hotelDetail'] = $hotelDetail;

        ##hotel detail
        $whatsapptmps = WhatsappTemplate::all();
        $data['whatsapptmps'] = $whatsapptmps;

        return view('admin.pages.hotel_panel.booking.ajax.index', $data);
    }

    public function detail(Request $request, $id)
    {
        $data = array();

        if(isset($id) && !empty($id)) {

            $hotel_id = Auth::guard('admin')->user()->hotel_id;

            $resultData = array();
            $resultData = Booking::where('hotel_id', $hotel_id)->where('id', $id)->first();

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

                $selected_rooms_json = $resultData['selected_room_type'];
                $selected_rooms = json_decode($selected_rooms_json);
                $data['selected_rooms'] = $selected_rooms;

                $selected_extras_json = $resultData['selected_extras'];
                $selected_extras = json_decode($selected_extras_json);
                $data['selected_extras'] = $selected_extras;

                ##hotel detail
                $hotelDetail = Hotel::where(['id' => $hotel_id])->first();
                $data['hotelDetail'] = $hotelDetail;

                return view('admin.pages.hotel_panel.booking.view_reservation', $data);
            }
        }
        return redirect()->back()->with('success', 'Room Type successfully deleted');
    }

    public function reports(){
        $data = array();
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $totalData = Booking::where('hotel_id', $hotel_id)->count();
        $data['totalData'] = $totalData;
        return view('admin.pages.hotel_panel.booking.reports', $data);
    }

    public function reportData_ajax(Request $request)
    {
        $data = array();
        $data_post = $request->all();

        $skip = $data_post['data_skip'];
        $per_page = $data_post['data_per_page'];

        $hotel_id = Auth::guard('admin')->user()->hotel_id;

        $resultData = Booking::where('hotel_id', $hotel_id)->where(function ($query) use ($data_post) {

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

                        $query->whereBetween('create_date', [$from_date, $to_date]);

                    } if ($select_search_by == "check_in") {

                        $query->whereBetween('check_in_date', [$from_date, $to_date]);

                    } if ($select_search_by == "check_out") {

                        $query->whereBetween('check_out_date', [$from_date, $to_date]);
                    }
                }
            }
        });

        $resultData = $resultData->orderBy('id', 'DESC')->offset($skip)->limit($per_page)->get();

        $data['resultData'] = $resultData;

        ##hotel detail
        $hotelDetail = Hotel::where(['id' => $hotel_id])->first();
        $data['hotelDetail'] = $hotelDetail;

        return view('admin.pages.hotel_panel.booking.ajax.report', $data);
    }

    public function booking_edit($id)
    {
        $data = array();

        if(isset($id) && !empty($id)) {

            $hotel_id = Auth::guard('admin')->user()->hotel_id;

            $resultData = array();
            $resultData = Booking::where('hotel_id', $hotel_id)->where('id', $id)->first();

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

                $selected_rooms_json = $resultData['selected_room_type'];
                $selected_rooms = json_decode($selected_rooms_json);
                $data['selected_rooms'] = $selected_rooms;

                $selected_extras_json = $resultData['selected_extras'];
                $selected_extras = json_decode($selected_extras_json);
                $data['selected_extras'] = $selected_extras;

                ##hotel detail
                $hotelDetail = Hotel::where(['id' => $hotel_id])->first();
                $data['hotelDetail'] = $hotelDetail;

                return view('admin.pages.hotel_panel.booking.edit_reservation', $data);
            }
     }
  }

  public function update(Request $request){
            $request->validate([
                'check_in_date'=>'required',
                'check_out_date'=>'required',
                'no_of_adult'=>'required',
                'first_name'=>'required',
                'last_name'=>'required',
                'phone'=>'required',
                'email'=>'required',
                'total_base_amount'=>'required',
                'gross_amount'=>'required'
            ]
        );
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $resultData = Booking::where('hotel_id', $hotel_id)->where('id', $request->id)->first();

        if($resultData){
            $resultData->check_in_date=$request->check_in_date;
            $resultData->check_out_date=$request->check_out_date;
            $resultData->booking_status=$request->booking_status;
            $resultData->no_of_adult=$request->no_of_adult;
            $resultData->no_of_child=$request->no_of_child;
            $resultData->first_name=$request->first_name;
            $resultData->last_name=$request->last_name;
            $resultData->phone=$request->phone;
            $resultData->email=$request->email;
            $resultData->country=$request->country;
            $resultData->guest_comment=$request->guest_comment;
            $resultData->total_base_amount=$request->total_base_amount;
            $resultData->total_extra_person_amount=$request->total_extra_person_amount;
            $resultData->extra_amount=$request->extra_amount;
            $resultData->total_discount=$request->total_discount;
            $resultData->gross_amount=$request->gross_amount;
            if(isset($request->not_has_whatsapp)){
                $resultData->not_has_whatsapp=$request->not_has_whatsapp;
            }else{
                $resultData->not_has_whatsapp=0;
            }

            if(isset($request->email_not_valid)){
                $resultData->email_not_valid=$request->email_not_valid;
            }else{
                $resultData->email_not_valid=0;
            }

            if(isset($request->promo_sent)){
                $resultData->promo_sent=$request->promo_sent;
            }else{
                $resultData->promo_sent=0;
            }

            if(isset($request->paid)){
                $resultData->paid=$request->paid;
            }else{
                $resultData->paid=0;
            }

            if(isset($request->promotion)){
                $resultData->promotion=$request->promotion;
            }else{
                $resultData->promotion=0;
            }

            if(isset($request->deposit_request)){
                $resultData->deposit_request=$request->deposit_request;
            }else{
                $resultData->deposit_request=0;
            }
            $resultData->internal_note=$request->internal_note;
            $resultData->save();
            return redirect()->back()->with('success', 'Reservation Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Something went wrong!');
        }
  }

  public function booking_status(Request $request){
        if(isset($request->id) && !empty($request->id)) {
                $hotel_id = Auth::guard('admin')->user()->hotel_id;
                $resultData = Booking::where('hotel_id', $hotel_id)->where('id',$request->id)->first();
                if(isset($resultData) && !empty($resultData)) {
                    if($request->type == "paid"){
                        if($resultData->paid == 0){
                            $resultData->paid=1;
                        }else{
                            $resultData->paid=0;
                        }
                    }

                    if($request->type == "called"){
                        if($resultData->is_called == 0){
                            $resultData->is_called=1;
                        }else{
                            $resultData->is_called=0;
                        }
                    }

                    if($request->type == "sent"){
                        if($resultData->is_sent == 0){
                            $resultData->is_sent=1;
                        }else{
                            $resultData->is_sent=0;
                        }
                    }
                    $resultData->save();
                    return true;
                }
        }
        return false;
  }

    public function booking_delete(Request $request){
            if(isset($request->id) && !empty($request->id)) {
                    $hotel_id = Auth::guard('admin')->user()->hotel_id;
                    $resultData = Booking::where('hotel_id', $hotel_id)->where('id',$request->id)->first();
                    if(isset($resultData) && !empty($resultData)) {
                        $resultData->delete();
                        return true;
                    }
            }
            return false;
        }

    public function booking_duplicat(Request $request){
        if(isset($request->id) && !empty($request->id)) {
                $resultDataold = Booking::find($request->id);
                $resultData = new Booking;
                $resultData->hotel_id=$resultDataold->hotel_id ;
                $resultData->first_name=$resultDataold->first_name;
                $resultData->last_name=$resultDataold->last_name;
                $resultData->phone=$resultDataold->phone;
                $resultData->email=$resultDataold->email;
                $resultData->arrival_time=$resultDataold->arrival_time;
                $resultData->country=$resultDataold->country;
                $resultData->no_of_adult=$resultDataold->no_of_adult;
                $resultData->no_of_child=$resultDataold->no_of_child;
                $resultData->child_ages=$resultDataold->child_ages;
                $resultData->guest_comment=$resultDataold->guest_comment;
                $resultData->check_in_date=$resultDataold->check_in_date;
                $resultData->check_out_date=$resultDataold->check_out_date;
                $resultData->booking_status=$resultDataold->booking_status;
                $resultData->total_base_amount=$resultDataold->total_base_amount;
                $resultData->total_extra_person_amount=$resultDataold->total_extra_person_amount;
                $resultData->extra_amount=$resultDataold->extra_amount;
                $resultData->total_discount=$resultDataold->total_discount;
                $resultData->gross_amount=$resultDataold->gross_amount;
                $resultData->category_code=$resultDataold->category_code;
                $resultData->t_type=$resultDataold->t_type;
                $resultData->selected_room_type=$resultDataold->selected_room_type;
                $resultData->selected_extras=$resultDataold->selected_extras;
                $resultData->is_posted=$resultDataold->is_posted;
                $resultData->attempt=$resultDataold->attempt;
                $resultData->tt1=$resultDataold->tt1;
                $resultData->deposit_amount=$resultDataold->deposit_amount;
                $resultData->referrer=$resultDataold->referrer;
                $resultData->note=$resultDataold->note;
                $resultData->not_has_whatsapp=$resultDataold->not_has_whatsapp;
                $resultData->email_not_valid=$resultDataold->email_not_valid;
                $resultData->promo_sent=$resultDataold->promo_sent;
                $resultData->paid=$resultDataold->paid;
                $resultData->promotion=$resultDataold->promotion;
                $resultData->deposit_request=$resultDataold->deposit_request;
                $resultData->internal_note=$resultDataold->internal_note;
                $resultData->save();
                if($resultData){
                    return true;
                }
                return false;
        }
        return false;
    }
}
