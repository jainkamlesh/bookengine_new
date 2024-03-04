<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hotel;
use App\Models\HotelSettings;
use App\Models\Admin;
use App\heplers\helper;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\Hash;

class HotelLoginController extends Controller
{
    public function index()
    {
        return view('admin.pages.hotel_panel.dashboard');
    }

    public function editProfile()
    {
        $admin = Auth::guard('admin')->user();
        $data = compact('admin');
        return view('admin.pages.hotel_panel.profile.edit_profile', $data);
    }

    public function saveProfile(request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'Name' => 'required',
                'UserName' => 'required',
                'Email' => 'required'
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $admin = Auth::guard('admin')->user();
        $admin->name = $request->Name;
        $admin->username = $request->UserName;
        $admin->email = $request->Email;

        if ($request->Profile != '') {

            $image = url('public/admin/images/profile' . $admin->profile_image);

            if (file_exists($image)) {
                File::delete($image);
            }

            $adminProfile = time() . '_adminprofile' . '.' . $request->Profile->guessClientExtension();
            $upload_path = 'public/admin/images/profile/';
            $request->Profile->move($upload_path, $adminProfile);
            $admin->profile_image = $adminProfile;
        }

        $admin->save();
        return redirect()->back()->with('success', 'Updated your profile');
    }

    public function changePassword()
    {
        return view('admin.pages.hotel_panel.profile.change_password');
    }

    public function savePassword(Request $request)
    {
        $request->validate([
            'CurrentPassword' => ['required'],
            'NewPassword' => ['required'],
            'NewConfirmPassword' => ['same:NewPassword']
        ]);
        $check = Hash::check($request->CurrentPassword, Auth::guard('admin')->user()->password);

        if ($check) {
            Admin::find(Auth::guard('admin')->user()->id)->update(['password' => Hash::make($request->NewPassword)]);

            // Update password in the hotel table
            $hotel_id = Admin::where('id', Auth::guard('admin')->user()->id)->value('hotel_id');

            if (!empty($hotel_id)) {
                $Hotel = Hotel::where(['id' => $hotel_id])->first();
                $Hotel->password = $request->NewPassword;
                $Hotel->save();

            }


            return redirect()->back()->with('success', 'Password Updated Successfully!');
        } else {
            return redirect()->back()->with('error', 'Current password not match');
        }
    }


    public function hotelProfile()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $hotel_data = Hotel::where('id', $hotel_id)->first();
        $hotel_setting = HotelSettings::where(['hotel_id' => $hotel_id])->first();

        $data = compact('hotel_data','hotel_setting');
        return view('admin.pages.hotel_panel.hotel_profile', $data);
    }

    public function br2nl($string){
        return preg_replace('#<br\s*/?>#i', "", $string);
    }

    public function store(request $request)
    {

        if ($request->isMethod('post')) {

            $rules = array(
                'name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'postal_code' => 'required',
                'mobile' => 'required',
                'contact_name' => 'required',
                'contact_email' => 'required',
                'city_tax' => 'required_with:other_info'
            );


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $Hotel = Hotel::where(['id' => $request->id])->first();

        // Save data in the hotels table
        $Hotel->name = $request->name;
        $Hotel->address = $request->address;
        $Hotel->city = $request->city;
        $Hotel->state = $request->state;
        $Hotel->country = $request->country;
        $Hotel->postal_code = $request->postal_code;
        $Hotel->mobile = $request->mobile;
        $Hotel->longtiude = $request->longtiude;
        $Hotel->latitude = $request->latitude;
        $Hotel->contact_name = $request->contact_name;
        $Hotel->contact_email = $request->contact_email;

        ##new fields
        $Hotel->star_rating = $request->star_rating;
        $Hotel->phone = $request->phone;
        $Hotel->category = $request->category;

        $Hotel->city_tax = $request->city_tax;
        $Hotel->paid_max_nights = $request->paid_max_nights;

        $Hotel->cc_policy= $request->cc_policy;
        $Hotel->cc_policy_it= $request->cc_policy_it;
        $Hotel->cc_policy_es= $request->cc_policy_es;
        $Hotel->cc_policy_de= $request->cc_policy_de;
        $Hotel->cc_policy_fr= $request->cc_policy_fr;

        // Extra fields
        $Hotel->website_url = $request->website_url;
        $Hotel->deposit_percentage = $request->deposit_percentage;
        $Hotel->reservation_email = $request->reservation_email;
        $Hotel->check_in = $request->check_in;
        $Hotel->check_out = $request->check_out;
        $Hotel->policy = nl2br(self::br2nl($request->policy));
        $Hotel->cancellation_policy = nl2br(self::br2nl($request->cancellation_policy));
        $Hotel->parking_info = nl2br(self::br2nl($request->parking_info));
        $Hotel->wifi_info = nl2br(self::br2nl($request->wifi_info));
        $Hotel->childress_policy = nl2br(self::br2nl($request->childress_policy));
        $Hotel->other_info = nl2br(self::br2nl($request->other_info));
        // $Hotel->banner_image = $request->banner_image;
        // $Hotel->logo_image = $request->logo_image;
        $Hotel->accepted_cards = json_encode($request->accepted_cards);
        $Hotel->special_note = nl2br(self::br2nl($request->special_note));

        $Hotel->special_note_it = nl2br(self::br2nl($request->special_note_it));
        $Hotel->policy_it = nl2br(self::br2nl($request->policy_it));
        $Hotel->cancellation_policy_it = nl2br(self::br2nl($request->cancellation_policy_it));
        $Hotel->parking_info_it = nl2br(self::br2nl($request->parking_info_it));
        $Hotel->wifi_info_it = nl2br(self::br2nl($request->wifi_info_it));
        $Hotel->childress_policy_it = nl2br(self::br2nl($request->childress_policy_it));
        $Hotel->other_info_it = nl2br(self::br2nl($request->other_info_it));

        $Hotel->special_note_fr = nl2br(self::br2nl($request->special_note_fr));
        $Hotel->policy_fr = nl2br(self::br2nl($request->policy_fr));
        $Hotel->cancellation_policy_fr = nl2br(self::br2nl($request->cancellation_policy_fr));
        $Hotel->parking_info_fr = nl2br(self::br2nl($request->parking_info_fr));
        $Hotel->wifi_info_fr = nl2br(self::br2nl($request->wifi_info_fr));
        $Hotel->childress_policy_fr = nl2br(self::br2nl($request->childress_policy_fr));
        $Hotel->other_info_fr = nl2br(self::br2nl($request->other_info_fr));

        $Hotel->special_note_es = nl2br(self::br2nl($request->special_note_es));
        $Hotel->policy_es = nl2br(self::br2nl($request->policy_es));
        $Hotel->cancellation_policy_es = nl2br(self::br2nl($request->cancellation_policy_es));
        $Hotel->parking_info_es = nl2br(self::br2nl($request->parking_info_es));
        $Hotel->wifi_info_es = nl2br(self::br2nl($request->wifi_info_es));
        $Hotel->childress_policy_es = nl2br(self::br2nl($request->childress_policy_es));
        $Hotel->other_info_es = nl2br(self::br2nl($request->other_info_es));

        $Hotel->special_note_de = nl2br(self::br2nl($request->special_note_de));
        $Hotel->policy_de = nl2br(self::br2nl($request->policy_de));
        $Hotel->cancellation_policy_de = nl2br(self::br2nl($request->cancellation_policy_de));
        $Hotel->parking_info_de = nl2br(self::br2nl($request->parking_info_de));
        $Hotel->wifi_info_de = nl2br(self::br2nl($request->wifi_info_de));
        $Hotel->childress_policy_de = nl2br(self::br2nl($request->childress_policy_de));
        $Hotel->other_info_de = nl2br(self::br2nl($request->other_info_de));

        $Hotel->bank_transfer = !empty($request->bank_transfer) ? $request->bank_transfer : 0;
        $Hotel->bank_transfer_desc = $request->bank_transfer_desc;
        $Hotel->is_apartments = $request->is_apartments;

        $start_age = $request->start_age;
        $end_age = $request->end_age;
        $child_age_arr = array();

        if (!empty($start_age) && !empty($end_age)) {
            foreach ($start_age as $key => $value) {
                $child_age_arr[$key]['start_age'] = $value;
            }

            foreach ($end_age as $key => $value) {
                $child_age_arr[$key]['end_age'] = $value;
            }
        }

        $Hotel->child_age = json_encode($child_age_arr);

        // banner
        if ($request->file('banner_image') != '' && !empty($request->file('banner_image'))) {
            $image_path = url('public/images/hotel_banner/' . $request->banner_image);

            if (file_exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = time() . '_hotel_banner' . '.' . request()->banner_image->guessClientExtension();
            $upload_path = 'public/images/hotel_banner/';

            request()->banner_image->move($upload_path, $imageName);
            $Hotel->banner_image = $imageName;
        }

        //logo
        if ($request->file('logo_image') != '' && !empty($request->file('logo_image'))) {
            $image_path = url('public/images/hotel_logo/' . $request->logo_image);

            if (file_exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = time() . '_hotel_logo' . '.' . request()->logo_image->guessClientExtension();
            $upload_path = 'public/images/hotel_logo/';

            request()->logo_image->move($upload_path, $imageName);
            $Hotel->logo_image = $imageName;
        }

        //logo
        if ($request->file('group_preview_image') != '' && !empty($request->file('group_preview_image'))) {
            $image_path = url('public/images/hotel_group_preview/' . $request->group_preview_image);

            if (file_exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = time() . '_hotel_group_preview' . '.' . request()->group_preview_image->guessClientExtension();
            $upload_path = 'public/images/hotel_group_preview/';

            request()->group_preview_image->move($upload_path, $imageName);
            $Hotel->group_preview_image = $imageName;
        }

        if ( isset($request->whatsapp) ) {
            $Hotel->whatsapp = $request->whatsapp;
        }

        if ( isset($request->currency_symbol) ) {
            $Hotel->currency_symbol = $request->currency_symbol;
        }
        else {
            $Hotel->currency_symbol = '';
        }

        $Hotel->review_hotel_id = $request->review_hotel_id;

        if ( isset($request->google_analytics_tag_id) && !empty($request->google_analytics_tag_id) ) {
            $Hotel->google_analytics_tag_id = $request->google_analytics_tag_id;
        }
        if ( isset($request->facebook_pixel_id) && !empty($request->facebook_pixel_id) ) {
            $Hotel->facebook_pixel_id = $request->facebook_pixel_id;
        }

        if ( isset($request->is_channel_manager_active) && !empty($request->is_channel_manager_active) ) {
            $Hotel->is_channel_manager_active = $request->is_channel_manager_active;
        }
        else {
            $Hotel->is_channel_manager_active = 'N';
        }

        ##set paypal
        if ( isset($request->paypal) ) {
            $Hotel->paypal = $request->paypal;
            $Hotel->paypal_client_id = $request->paypal_client_id;
            $Hotel->paypal_client_secret = $request->paypal_client_secret;
        }
        else {
            $Hotel->paypal = 0;
            $Hotel->paypal_client_id = '';
            $Hotel->paypal_client_secret = '';
        }

        // Save data in the Admin table
        $Hotel->save();

        ##save setting
        $HotelSettings = HotelSettings::where(['hotel_id' => $request->id])->first();
        if (empty($HotelSettings)) {
            $HotelSettings = new HotelSettings;
            $HotelSettings->hotel_id = $request->id;
        }

        if ( isset($request->min_advance_days) && $request->min_advance_days > 0 ) {
            $HotelSettings->min_advance_days = $request->min_advance_days;
        }
        else {
            $HotelSettings->min_advance_days = 0;
        }
        if ( isset($request->max_advance_days) && $request->max_advance_days > 0 ) {
            $HotelSettings->max_advance_days = $request->max_advance_days;
        }
        else {
            $HotelSettings->max_advance_days = 0;
        }
        // Save data in the Admin table
        $HotelSettings->save();
        
        return redirect()->back()->with('success', 'Hotel successfully uploaded');
    }

    // public function calender()
    // {
    //   return view('admin.pages.hotel_panel.calender');
    // }
}
