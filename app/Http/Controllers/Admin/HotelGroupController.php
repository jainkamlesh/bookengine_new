<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\HotelGroup;
use App\Models\Hotel;
use App\Models\Admin;
use App\heplers\helper;
use Illuminate\Support\Facades\Hash;
use Str;
use Auth;
class HotelGroupController extends Controller
{
    //
	public function index()
    {
        $hotelgroups = HotelGroup::orderBy('id', 'DESC')->Paginate(200);
        $hotelgpCnt = $hotelgroups->count();
        $data = compact('hotelgroups', 'hotelgpCnt');
        return view('admin.pages.hotel_group.index', $data);
    }
	public function add()
    {
		$hotelgroups = Hotel::orderBy('id', 'DESC')->Paginate(200);
        $hotelgpCnt = $hotelgroups->count();
        $data = compact('hotelgroups', 'hotelgpCnt');
        return view('admin.pages.hotel_group.add_hotelgroup',$data);
    }
	public function edit($id)
    {
		$hotelbygroup = HotelGroup::where(['id' => $id])->first();
        $hotelgroups = Hotel::orderBy('id', 'DESC')->Paginate(200);
        $hotelgpCnt = $hotelgroups->count();
        $data = compact('hotelbygroup','hotelgroups', 'hotelgpCnt');
        return view('admin.pages.hotel_group.edit_hotelgroup', $data);
    }
    public function editProfile(request $request)
    {
        $group_hotel_id = Auth::guard('admin')->user()->hotel_id;
        
        $hotelbygroup = HotelGroup::where(['id' => $group_hotel_id])->first();

        $hotelgroups = Hotel::orderBy('id', 'DESC')->Paginate(200);
        $hotelgpCnt = $hotelgroups->count();
        $is_group = 1;
        $data = compact('hotelbygroup','hotelgroups', 'hotelgpCnt', 'is_group');
        return view('admin.pages.hotel_group.edit_hotelgroup', $data);
    }
    public function list($id)
    {
        $hotelgroups = HotelGroup::where(['id' => $id])->first();
        if ( isset($hotelgroups->groupids) && !empty($hotelgroups->groupids) ) {
            $hotel_list = unserialize($hotelgroups->groupids);

            if ( !empty($hotel_list) && is_array($hotel_list) ) {
                $hotels = Hotel::wherein('id', $hotel_list)->orderBy('id', 'DESC')->get();
            }
        }
        $hotelCnt = $hotels->count();

        $data = compact('hotelgroups','hotels','hotelCnt');
        return view('admin.pages.hotel_group.group_hotel_list', $data);
    }

	public function store(request $request)
    {
        try {
        if ($request->isMethod('post')) {
            if (empty($request->id)) {
                $rules = array(
                    'businessname' => 'required|unique:hotel_groups,businessname',
                    'phone' => 'required',
                    'email' => 'required|email|unique:hotel_groups,email',
                    'backgroundimage' => 'image|mimes:jpeg,png,jpg',
					'selecthotelids' => 'required',
                );
            } else {
                $rules = array(
					'businessname' => 'required',
					'phone' => 'required',
                    'email' => 'required',
                    'backgroundimage' => 'image|mimes:jpeg,png,jpg',
					'selecthotelids' => 'required',
                );
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
		$hotelGroup = HotelGroup::where(['id' => $request->id])->first();
        if (empty($hotelGroup)) {
            $hotelGroup = new HotelGroup();
        }

        if ($request->file('backgroundimage') != '') {
            $image_path = url('public/images/hotel_group/' . $request->backgroundimage);

            if (file_exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = time() . '_hotel_group' . '.' . request()->backgroundimage->guessClientExtension();
            $upload_path = 'public/images/hotel_group/';

            request()->backgroundimage->move($upload_path, $imageName);
            $hotelGroup->backgroundimage = $imageName;
        }
        if ($request->file('logo') != '') {
            $image_path = url('public/images/hotel_group_logo/' . $request->logo);

            if (file_exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = time() . '_hotel_group' . '.' . request()->logo->guessClientExtension();
            $upload_path = 'public/images/hotel_group_logo/';

            request()->logo->move($upload_path, $imageName);
            $hotelGroup->logo = $imageName;
        }

		$gropid = '';
		if(isset($request->selecthotelids) && is_array($request->selecthotelids)){
			$gropid = serialize($request->selecthotelids);
		}
        $hotelGroup->businessname = $request->businessname;
        $hotelGroup->phone = $request->phone;
        $hotelGroup->email = $request->email;
        $hotelGroup->customcss = $request->customcss;
        $hotelGroup->groupids = $gropid;
        $hotelGroup->save();

        $hotel_group_id = $hotelGroup->id;

        //add in admin
        $Admin = Admin::where(['hotel_id' => $hotel_group_id])->first();
        if (empty($Admin)) {
            $Admin = new Admin; 
        }

        $Admin->role_id = 3;
        $Admin->hotel_id = $hotel_group_id;
        $Admin->group_hotel_ids = $gropid;
        $Admin->name = $request->businessname;
        $Admin->email = $request->email;
        $Admin->username = $request->email;
        $Admin->role = 3;
        $Admin->password = Hash::make($request->password);
        $Admin->save();

        return redirect()->back()->with('success', 'Hotel group successfully saved');
        } catch (Exception $e) {
            echo $e;
        }
	}
	public function delete($id)
    {
        $Hotelgb = HotelGroup::where(['id' => $id])->first();
        $Hotelgb->delete();
        return redirect()->back()->with('success', 'Hotel group successfully deleted');
    }
}
