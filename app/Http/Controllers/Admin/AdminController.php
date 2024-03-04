<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\Hotel;
use Auth;
use Response;
use Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // public function index()
    // {
    //   return view('admin.pages.hotels.index');
    // }

    public function index()
    {
        return view('admin.login');
    }

    public function checkLogin(Request $request)
    {
        if (isset($request->language) && $request->language != '' ) {
            //app()->setLocale($request->language);
            \App::setLocale($request->language);
            session()->put('locale', $request->language);
          /*   echo  $request->language;
            print_r(session()->all());
            dd(__('hotels_label.hotel_list')); */
            
        }
        else {
           // app()->setLocale('en');
           \App::setLocale($request->language);
            session()->put('locale', 'en');
        }

        if ($request->isMethod('post')) {
            $rules = array(
                'username' => 'required',
                'password' => 'required'
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        // $c = app()->getLocale(); echo $c;die;
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {

            if ((Auth::guard('admin')->user()->role_id == 2) AND (!empty(Auth::guard('admin')->user()->hotel_id))) {

                $hotel_slug = Hotel::where(['id' => Auth::guard('admin')->user()->hotel_id])->value('slug');

                if (empty($hotel_slug)) {
                    return redirect()->back()->with('error', 'Something went wrong');
                } else {
                    return redirect()->route('admin.hotel.calender', $hotel_slug);
                }
                // Enter route here
            } elseif ((Auth::guard('admin')->user()->role_id == 3) AND (!empty(Auth::guard('admin')->user()->hotel_id))) {

                $group_hotel_ids = Auth::guard('admin')->user()->group_hotel_ids;

                if (empty($group_hotel_ids)) {
                    return redirect()->back()->with('error', 'Something went wrong');
                } else {
                    return redirect()->route('admin.hotelgrouplist', Auth::guard('admin')->user()->hotel_id);
                }
                // Enter route here
            } else {


                return redirect()->route('admin.hotels');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.index');
    }

    public function editProfile()
    {
        $admin = Auth::guard('admin')->user();
        $data = compact('admin');
        return view('admin.pages.profile.edit_profile', $data);
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

    public function byPassHotelLogin($id = NULL)
    {
        if (empty($id)) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $user_id = Admin::where('hotel_id', $id)->value('id');
        $username = Admin::where('hotel_id', $id)->value('username');
        $hotel_slug = Hotel::where('id', $id)->value('slug');
        $password = Hotel::where('id', $id)->value('password');

        if (Auth::guard('admin')->attempt(['username' => $username, 'password' => $password])) {
            return redirect()->route('admin.hotel.booking', $hotel_slug);
        } else {
            return redirect()->back()->with('error', 'Something went wrong');

        }
        // Auth::loginUsingId($user_id);
    }
}
