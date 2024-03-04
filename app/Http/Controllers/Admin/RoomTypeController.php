<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\heplers\helper;
use Auth;
use Str;
use File;
use Storage;
use App\Models\RoomType;
use App\Models\RoomFacility;
use App\Models\Hotel;

class RoomTypeController extends Controller
{
    public function index()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $roomType = RoomType::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->Paginate(100);
        $roomTypeCnt = $roomType->count();

        $listRoomFacility = RoomFacility::pluck('name', 'id')->toArray();

        $data = compact('roomType', 'roomTypeCnt', 'listRoomFacility');

        return view('admin.pages.hotel_panel.room_type.index', $data);
    }

    public function add()
    {
        $listRoomFacility = RoomFacility::pluck('name', 'id')->toArray();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $hotel_data = Hotel::where('id', $hotel_id)->first();

        $data = compact('listRoomFacility', 'hotel_data');

        return view('admin.pages.hotel_panel.room_type.add_room_type', $data);
    }

    public function edit($id)
    {
        $roomType = RoomType::where(['id' => $id])->first();
        $listRoomFacility = RoomFacility::pluck('name', 'id')->toArray();

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $hotel_data = Hotel::where('id', $hotel_id)->first();

        $data = compact('roomType', 'listRoomFacility', 'hotel_data');

        return view('admin.pages.hotel_panel.room_type.edit_room_type', $data);
    }

    public function br2nl($string){
        return preg_replace('#<br\s*/?>#i', "", $string);
    }
	public function deleteimage(request $request){
		$return_arr = array();
		if ($request->isMethod('post')) {
			$image_path = public_path('public/images/room_type'.$request->imgname);
			if(isset($request->id) && !empty($request->id)){
			$id = $request->id;
			$name = $request->imgname;
			$roomType = RoomType::where(['id' => $id])->first();
			if(isset($roomType->room_image) && !empty($roomType->room_image)){
				$imgr = explode(',',$roomType->room_image);
				if(sizeof($imgr) >0){
					if (in_array($name, $imgr)){
						unset($imgr[array_search($name,$imgr)]);
						$imgsr = implode(',', $imgr);
						RoomType::where('id', $id)
					   ->update([
						   'room_image' => $imgsr
						]);
						if (file_exists($image_path)) {
						@unlink($image_path);
							$return_arr['status'] = 200;
						}
						$return_arr['status'] = 200;
					}
				}
			}
		}else{
			if (file_exists($image_path)) {
				@unlink($image_path);
					$return_arr['status'] = 200;
				}
			}
		}
		echo json_encode($return_arr);exit;
	}
	public function storeimage(request $request)
    {
		if ($request->isMethod('post')) {
                
			$return_arr = array();
				if ($request->hasFile('files')) {
					$imgtype = ['jpeg','png','jpg'];
					foreach($request->file('files') as $file){
						$imageName = 'room_type_'.time() . '_' . rand(1111, 9999) . rand(1111, 9999);
                        if ( isset($request->room_type_id) ) {
                            $imageName .= '_'.$request->room_type_id;
                        }

						$emgext = $file->getClientOriginalExtension();
						$upload_path = 'public/images/room_type/';
						if(in_array($emgext,$imgtype)){
							$file->move($upload_path, $imageName);
							$src = asset("/public/images/room_type/".$imageName);
							$return_arr[] = array("name" => $imageName, "src"=> $src);
						}
						
					}
				}
			
		}
		echo json_encode($return_arr);
		exit;
	}
    public function store(request $request)
    {

        if ($request->isMethod('post')) {
            if (empty($request->id)) {
                $rules = array(
                    'name' => 'required',
                    /*'short_description' => 'required',
                    'base_adults' => 'required',
                    'max_adults' => 'required',
                    'max_child' => 'required',*/
                    // 'size' => 'required',
                    // 'size_unit' => 'required',
                    'room_image[]' => 'image|mimes:jpeg,png,jpg|max:2048',
                );
            } else {
                $rules = array(
                    'name' => 'required',
                    /*'short_description' => 'required',
                    'base_adults' => 'required',
                    'max_adults' => 'required',
                    'max_child' => 'required',*/
                    // 'size' => 'required',
                    // 'size_unit' => 'required',
                    'room_image[]' => 'image|mimes:jpeg,png,jpg|max:2048',
                );
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $is_exist = 1;
        $roomType = RoomType::where(['id' => $request->id])->first();
        if (empty($roomType)) {
            $roomType = new RoomType;
            $is_exist = 0;
        }

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $roomType->name = $request->name;
        $roomType->name_it = $request->name_it;
        $roomType->name_fr = $request->name_fr;
        $roomType->name_de = $request->name_de;
        $roomType->name_es = $request->name_es;

        $roomType->hotel_id = $hotel_id;

        $roomType->short_description = NULL;
        if(isset($request->short_description) && !empty($request->short_description)) {

            $roomType->short_description = trim(nl2br(self::br2nl($request->short_description)));
        }
        $roomType->short_description_it = NULL;
        if(isset($request->short_description_it) && !empty($request->short_description_it)) {

            $roomType->short_description_it = trim(nl2br(self::br2nl($request->short_description_it)));
        }
        $roomType->short_description_fr = NULL;
        if(isset($request->short_description_fr) && !empty($request->short_description_fr)) {

            $roomType->short_description_fr = trim(nl2br(self::br2nl($request->short_description_fr)));
        }
        $roomType->short_description_de = NULL;
        if(isset($request->short_description_de) && !empty($request->short_description_de)) {

            $roomType->short_description_de = trim(nl2br(self::br2nl($request->short_description_de)));
        }
        $roomType->short_description_es = NULL;
        if(isset($request->short_description_es) && !empty($request->short_description_es)) {

            $roomType->short_description_es = trim(nl2br(self::br2nl($request->short_description_es)));
        }

        $roomType->long_description = NULL;
        if(isset($request->long_description) && !empty($request->long_description)) {

            $roomType->long_description = trim(nl2br(self::br2nl($request->long_description)));
        }
        $roomType->long_description_it = NULL;
        if(isset($request->long_description_it) && !empty($request->long_description_it)) {

            $roomType->long_description_it = trim(nl2br(self::br2nl($request->long_description_it)));
        }
        $roomType->long_description_fr = NULL;
        if(isset($request->long_description_fr) && !empty($request->long_description_fr)) {

            $roomType->long_description_fr = trim(nl2br(self::br2nl($request->long_description_fr)));
        }
        $roomType->long_description_de = NULL;
        if(isset($request->long_description_de) && !empty($request->long_description_de)) {

            $roomType->long_description_de = trim(nl2br(self::br2nl($request->long_description_de)));
        }
        $roomType->long_description_es = NULL;
        if(isset($request->long_description_es) && !empty($request->long_description_es)) {

            $roomType->long_description_es = trim(nl2br(self::br2nl($request->long_description_es)));
        }

        $roomType->room_facilities = NULL;
        if(isset($request->room_facilities) && !empty($request->room_facilities)) {

            $roomType->room_facilities = implode(",",$request->room_facilities);
        }

        $roomType->base_adults = $request->base_adults;
        $roomType->max_adults = $request->max_adults;
        $roomType->max_child = $request->max_child;
        $roomType->size = $request->size;
        $roomType->size_unit = $request->size_unit;
        $roomType->room_capacity = $request->room_capacity;

        $roomType->room_order = $request->room_order;

        if ( isset($request->twin_double) && $request->twin_double != '' ) {
            $roomType->twin_double = $request->twin_double;
        }

        if ( isset($request->no_of_bedroom) && $request->no_of_bedroom > 0 ) {
            $roomType->no_of_bedroom = $request->no_of_bedroom;
        }
        if ( isset($request->no_of_bathroom) && $request->no_of_bathroom > 0 ) {
            $roomType->no_of_bathroom = $request->no_of_bathroom;
        }
        if ( isset($request->floor) && $request->floor > 0 ) {
            $roomType->floor = $request->floor;
        }
 

        /* $ar_files = array();
        if (isset($roomType->room_image) && !empty($roomType->room_image)) {
            $ar_files = explode(",", $roomType->room_image);
        }

        if (isset($request->is_delete_image) && !empty($request->is_delete_image)) {

            $ar_files = array();

            $ar_is_delete_image = array();
            $ar_is_delete_image = $request->is_delete_image;
            foreach ($ar_is_delete_image as $key => $value) {

                if ($value == 1) {
                    $image_path = 'public/images/room_type/' . trim($key);
                    if (file_exists($image_path)) {
                        File::delete($image_path);
                    }
                } else {
                    array_push($ar_files, $key);
                }
            }
        } */

        /* if ($request->file('room_image') != '') {

            $files = $request->file('room_image');
            foreach ($files as $file) {

                $imageName = time() . '_' . rand(111, 999) . rand(1111, 9999) . '_room_type' . '.' . $file->guessClientExtension();
                $upload_path = 'public/images/room_type/';

                $file->move($upload_path, $imageName);

                array_push($ar_files, $imageName);
            }
        } */

        /* if (isset($ar_files) && !empty($ar_files)) {

            $ar_files = array_unique($ar_files);
            $ar_files = array_filter($ar_files);

           $roomType->room_image = implode(",", $ar_files);
        } else {
            $roomType->room_image = NULL;
        } */
		$imarr = '';
		if(isset($request->imggalleryj) && !empty($request->imggalleryj)){
			$imggall = explode(",",$request->imggalleryj);
			array_pop($imggall);
			$imarr  = implode(',', $imggall);
		}else{	
			$imarr  = $roomType->room_image;
		}
		
		$roomType->room_image = $imarr;
		//$roomType->room_image_gallery = $imarr;
        $roomType->save();

        if ( $is_exist ) {
            $roomType_id = $roomType->id;
            $string = "RoomType_".$hotel_id."_".$roomType_id."_0_0";

            $rand_number = floor(microtime(true) * 1000);
            $file_name = "RatePlan/".$rand_number.".txt";
            Storage::disk('public')->put($file_name, $string);
        }
        return redirect()->back()->with('success', 'Room Type successfully uploaded');
    }

    public function delete($id)
    {
        $roomType = RoomType::where(['id' => $id])->first();
        if (isset($roomType) && !empty($roomType)) {

            $ar_files = array();
            if (isset($roomType->room_image) && !empty($roomType->room_image)) {
                $ar_files = explode(",", $roomType->room_image);
            }

            if (isset($ar_files) && !empty($ar_files)) {
                foreach ($ar_files as $key => $value) {
                    $image_path = 'public/images/room_type/' . trim($value);
                    if (file_exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }

            $roomType->delete();
        }
        return redirect()->back()->with('success', 'Room Type successfully deleted');
    }
}
