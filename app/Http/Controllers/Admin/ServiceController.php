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
use App\Models\Service;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $service = Service::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->Paginate(100);
        $serviceCnt = $service->count();

        $data = compact('service', 'serviceCnt');

        return view('admin.pages.hotel_panel.service.index', $data);
    }

    public function add()
    {
        return view('admin.pages.hotel_panel.service.add_service');
    }

    public function edit($id)
    {
        $service = Service::where(['id' => $id])->first();

        $data = compact('service');

        return view('admin.pages.hotel_panel.service.edit_service', $data);
    }

    public function br2nl($string){
        return preg_replace('#<br\s*/?>#i', "", $string);
    }
    public function deleteimage(request $request){
        $return_arr = array();
        if ($request->isMethod('post')) {
            $image_path = public_path('public/images/service'.$request->imgname);
            if(isset($request->id) && !empty($request->id)){
            $id = $request->id;
            $name = $request->imgname;
            $service = Service::where(['id' => $id])->first();
            if(isset($service->images) && !empty($service->images)){
                $imgr = explode(',',$service->images);
                if(sizeof($imgr) >0){
                    if (in_array($name, $imgr)){
                        unset($imgr[array_search($name,$imgr)]);
                        $imgsr = implode(',', $imgr);
                        Service::where('id', $id)
                       ->update([
                           'images' => $imgsr
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
                        $imageName = 'service_'.time() . '_' . rand(1111, 9999) . rand(1111, 9999);
                        if ( isset($request->id) ) {
                            $imageName .= '_'.$request->id;
                        }

                        $emgext = $file->getClientOriginalExtension();

                        $upload_path = 'public/images/service/';
                        if(in_array($emgext,$imgtype)){
                            $imageName .= ".".$emgext;

                            $file->move($upload_path, $imageName);
                            $src = asset("/public/images/service/".$imageName);
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
                    'room_image[]' => 'image|mimes:jpeg,png,jpg|max:2048',
                );
            } else {
                $rules = array(
                    'name' => 'required',
                    'room_image[]' => 'image|mimes:jpeg,png,jpg|max:2048',
                );
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $is_exist = 1;
        $service = Service::where(['id' => $request->id])->first();
        if (empty($service)) {
            $service = new Service;
            $is_exist = 0;
        }

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $service->name = $request->name;
        $service->name_it = $request->name_it;
        $service->name_fr = $request->name_fr;
        $service->name_de = $request->name_de;
        $service->name_es = $request->name_es;

        $service->hotel_id = $hotel_id;

        $service->short_description = NULL;
        if(isset($request->short_description) && !empty($request->short_description)) {

            $service->short_description = trim(nl2br(self::br2nl($request->short_description)));
        }
        $service->short_description_it = NULL;
        if(isset($request->short_description_it) && !empty($request->short_description_it)) {

            $service->short_description_it = trim(nl2br(self::br2nl($request->short_description_it)));
        }
        $service->short_description_fr = NULL;
        if(isset($request->short_description_fr) && !empty($request->short_description_fr)) {

            $service->short_description_fr = trim(nl2br(self::br2nl($request->short_description_fr)));
        }
        $service->short_description_de = NULL;
        if(isset($request->short_description_de) && !empty($request->short_description_de)) {

            $service->short_description_de = trim(nl2br(self::br2nl($request->short_description_de)));
        }
        $service->short_description_es = NULL;
        if(isset($request->short_description_es) && !empty($request->short_description_es)) {

            $service->short_description_es = trim(nl2br(self::br2nl($request->short_description_es)));
        }

        $service->cancellation_policy = NULL;
        if(isset($request->cancellation_policy) && !empty($request->cancellation_policy)) {

            $service->cancellation_policy = trim(nl2br(self::br2nl($request->cancellation_policy)));
        }
        $service->cancellation_policy_it = NULL;
        if(isset($request->cancellation_policy_it) && !empty($request->cancellation_policy_it)) {

            $service->cancellation_policy_it = trim(nl2br(self::br2nl($request->cancellation_policy_it)));
        }
        $service->cancellation_policy_fr = NULL;
        if(isset($request->cancellation_policy_fr) && !empty($request->cancellation_policy_fr)) {

            $service->cancellation_policy_fr = trim(nl2br(self::br2nl($request->cancellation_policy_fr)));
        }
        $service->cancellation_policy_de = NULL;
        if(isset($request->cancellation_policy_de) && !empty($request->cancellation_policy_de)) {

            $service->cancellation_policy_de = trim(nl2br(self::br2nl($request->cancellation_policy_de)));
        }
        $service->cancellation_policy_es = NULL;
        if(isset($request->cancellation_policy_es) && !empty($request->cancellation_policy_es)) {

            $service->cancellation_policy_es = trim(nl2br(self::br2nl($request->cancellation_policy_es)));
        }

        $service->max_quantity = $request->max_quantity;
        $service->price = $request->price;
        $service->tax = $request->tax;
        $service->display_order = $request->display_order;
        
        $imarr = '';
        if(isset($request->imggalleryj) && !empty($request->imggalleryj)){
            $imggall = explode(",",$request->imggalleryj);
            array_pop($imggall);
            $imarr  = implode(',', $imggall);
        }else{  
            $imarr  = $service->images;
        }
        
        $service->images = $imarr;
        //$roomType->room_image_gallery = $imarr;
        $service->save();

        return redirect()->back()->with('success', 'Service successfully uploaded');
    }

    public function delete($id)
    {
        $service = Service::where(['id' => $id])->first();
        if (isset($service) && !empty($service)) {

            $ar_files = array();
            if (isset($service->images) && !empty($service->images)) {
                $ar_files = explode(",", $service->images);
            }

            if (isset($ar_files) && !empty($ar_files)) {
                foreach ($ar_files as $key => $value) {
                    $image_path = 'public/images/service/' . trim($value);
                    if (file_exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }

            $service->delete();
        }
        return redirect()->back()->with('success', 'Service successfully deleted');
    }
}
