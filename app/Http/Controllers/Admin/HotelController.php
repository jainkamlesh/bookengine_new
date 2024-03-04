<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hotel;
use App\Models\Admin;
use App\heplers\helper;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\Hash;
use Storage;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::orderBy('id', 'DESC')->Paginate(200);
        $hotelCnt = $hotels->count();
        $data = compact('hotels', 'hotelCnt');
        return view('admin.pages.hotels.index', $data);
    }

    public function add()
    {
        return view('admin.pages.hotels.add_hotel');
    }

    public function edit($id)
    {
        $hotel = Hotel::where(['id' => $id])->first();
        $data = compact('hotel');
        return view('admin.pages.hotels.edit_hotel', $data);
    }

    public function store(request $request)
    {
        if ($request->isMethod('post')) {

            if (empty($request->id)) {
                $rules = array(
                    'name' => 'required|unique:hotels,name',
                    'address' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'country' => 'required',
                    'postal_code' => 'required',
                    'mobile' => 'required',
                    'contact_name' => 'required',
                    'contact_email' => 'required',
                    'username' => 'required',
                    'password' => 'required',
                );
            } else {
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
                    'username' => 'required',
                    'password' => 'required',
                );
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $Hotel = Hotel::where(['id' => $request->id])->first();
        $Admin = Admin::where(['hotel_id' => $request->id])->first();
        if (empty($Hotel)) {
            $Hotel = new Hotel;
            $Admin = new Admin;
        }
        if ( empty($Admin)) {
            $Admin = new Admin;    
        }

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
        $Hotel->username = $request->username;
        $Hotel->password = $request->password;
        if ( isset($request->google) ) {
            $Hotel->google = $request->google;
        }
        else {
            $Hotel->google = 'N';
        }

        if ( isset($request->adult_only) ) {
            $Hotel->adult_only = $request->adult_only;
        }
        else {
            $Hotel->adult_only = 'N';
        }
        
        if ( isset($request->dont_show_na_calendar) ) {
            $Hotel->dont_show_na_calendar = $request->dont_show_na_calendar;
        }
        else {
            $Hotel->dont_show_na_calendar = 'N';
        }

        if ( isset($request->on_request_booking) ) {
            $Hotel->on_request_booking = $request->on_request_booking;
        }
        else {
            $Hotel->on_request_booking = 'N';
        }

        if ( isset($request->booking_engine_type) ) {
            $Hotel->booking_engine_type = $request->booking_engine_type;
        }
        else {
            $Hotel->booking_engine_type = 'Hotel';
        }

        $Hotel->custom_css = $request->custom_css;

        $Hotel->review_hotel_id = $request->review_hotel_id;

        // Save data in the Admin table
        $Hotel->save();

        // Save slug functionality
        $insertedId = $Hotel->id;
        $slug = $request->name;
        $slug = Str::slug($slug, '-');
        $input['slug'] = $slug;
        // $input['slug'] = $slug."-".$insertedId;
        $res = Hotel::whereId($insertedId)->update($input);

        $Admin->role_id = 2;
        $Admin->hotel_id = $Hotel->id;
        $Admin->name = $request->contact_name;
        $Admin->email = $request->contact_email;
        $Admin->username = $request->username;
        $Admin->role = 2;
        $Admin->password = Hash::make($request->password);
        $Admin->save();

        if ( $request->google == 'Y' ) {
            $string = "Hotel_".$insertedId."_0_0_0";

            $rand_number = floor(microtime(true) * 1000);
            $file_name = "RatePlan/".$rand_number.".txt";
            Storage::disk('public')->put($file_name, $string);
        }

        return redirect()->back()->with('success', 'Hotel successfully uploaded');
    }

    public function delete($id)
    {
        $Hotel = Hotel::where(['id' => $id])->first();
        $Hotel->delete();
        return redirect()->back()->with('success', 'Hotel successfully deleted');
    }

    public function hotelstatus($id, Request $request)
    {
        $Hotel = Hotel::where(['id' => $id])->first();
        $status = $request->status;
        
        $Hotel->hotel_status = $status;

        // Save data in the Admin table
        $Hotel->save();

        return redirect()->back()->with('success', 'Hotel updated successfully');
    }


    public function GoogleMapAPI(Request $request)
    {
        $address = $request->address;
        $endcode_addr = urlencode($request->address);

        $lat = 0;
        $long = 0;
        // Get Lat long using the address
        $curl = curl_init();

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $endcode_addr . '&key=AIzaSyCtjsTkJAAyuwhh37xjbZ1eCpA_QoUN8rQ';

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        } else {
            $data = json_decode($response, true);

            if (!empty($data)) {
                $formatted_address = $data['results'][0]['formatted_address'];
                $lat = $data['results'][0]['geometry']['location']['lat'];
                $long = $data['results'][0]['geometry']['location']['lng'];

            }
        }

        curl_close($curl);


        // To find country state city using lat long


        if ($lat != 0 AND $long != 0) {

            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $long . '&sensor=false&key=AIzaSyCtjsTkJAAyuwhh37xjbZ1eCpA_QoUN8rQ';

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
            } else {
                $api_data = json_decode($response, true);


                foreach ($api_data['results'][0]['address_components'] as $address_componenets) {
                    if ($address_componenets["types"][0] == "country") {
                        $country = $address_componenets["long_name"];
                    }
                    if ($address_componenets["types"][0] == "administrative_area_level_1") {
                        $state = $address_componenets["long_name"];
                    }
                    if ($address_componenets["types"][0] == "locality") {
                        $city = $address_componenets["long_name"];
                    }
                    if ($address_componenets["types"][0] == "postal_code") {
                        $postal_code = $address_componenets["long_name"];
                    }
                }
                // Resume work to process the data from here
                // $city = $api_data['results'][0]['address_components'][3]['long_name'];                             
                // $state = $api_data['results'][0]['address_components'][4]['long_name'];                             
                // $country = $api_data['results'][0]['address_components'][5]['long_name'];                             
                // $postal_code = $api_data['results'][0]['address_components'][6]['long_name'];                             
                $return_arr = array(
                    'lat' => $lat,
                    'long' => $long,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'postal_code' => $postal_code
                );

                echo json_encode($return_arr);
            }
            curl_close($curl);
        }
    }

    public function downloadHotelWidget(Request $request)
    {
        $data = array();

        $user_id = Auth::guard('admin')->user()->id;
        $user_role = Auth::guard('admin')->user()->role;
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $hotel_name = Hotel::where('id', $user_id)->value('name');
        $hotel_slug = Hotel::where('id', $user_id)->value('slug');

        if ($user_role == 1) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data['hotel_id'] = $hotel_id;
        $data['hotel_name'] = $hotel_name;
        $data['hotel_slug'] = $hotel_slug;

        return view('admin.pages.widget.index', $data);
    }
}
