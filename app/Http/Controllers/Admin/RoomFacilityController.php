<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RoomFacility;
use App\heplers\helper;
use Str;

class RoomFacilityController extends Controller
{
    public function index()
    {
        $roomFacility = RoomFacility::orderBy('id', 'DESC')->Paginate(10);
        $roomFacilityCnt = $roomFacility->count();
        $data = compact('roomFacility', 'roomFacilityCnt');

        return view('admin.pages.room_facility.index', $data);
    }

    public function add()
    {
        return view('admin.pages.room_facility.add_room_facility');
    }

    public function edit($id)
    {
        $roomFacility = RoomFacility::where(['id' => $id])->first();
        $data = compact('roomFacility');
        return view('admin.pages.room_facility.edit_room_facility', $data);
    }


    public function store(request $request)
    {
        if ($request->isMethod('post')) {
            if (empty($request->id)) {
                $rules = array(
                    'name' => 'required|unique:room_facilities',
                    'icon' => 'image|mimes:jpeg,png,jpg|max:2048',
                );
            } else {
                $rules = array(
                    'icon' => 'image|mimes:jpeg,png,jpg|max:2048',
                );
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $roomFacility = RoomFacility::where(['id' => $request->id])->first();
        if (empty($roomFacility)) {
            $roomFacility = new RoomFacility();
        }

        if ($request->file('icon') != '') {
            $image_path = url('public/images/room_facility/' . $request->icon);

            if (file_exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = time() . '_room_facility' . '.' . request()->icon->guessClientExtension();
            $upload_path = 'public/images/room_facility/';

            request()->icon->move($upload_path, $imageName);
            $roomFacility->icon = $imageName;
        }


        $roomFacility->name = $request->name;
        $roomFacility->save();

        return redirect()->back()->with('success', 'Room Facility successfully uploaded');
    }

    public function delete($id)
    {
        $roomFacility = RoomFacility::where(['id' => $id])->first();
        $roomFacility->delete();
        return redirect()->back()->with('success', 'Room Facility successfully deleted');
    }
}
