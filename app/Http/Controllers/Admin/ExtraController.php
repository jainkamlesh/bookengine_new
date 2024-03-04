<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Extra;
use App\heplers\helper;
use Auth;
use Str;

class ExtraController extends Controller
{
    public function index()
    {
        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $extra = Extra::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->Paginate(10);
        $extraCnt = $extra->count();
        $data = compact('extra', 'extraCnt');

        return view('admin.pages.hotel_panel.extra.index', $data);
    }

    public function add()
    {
        return view('admin.pages.hotel_panel.extra.add_extra');
    }

    public function edit($id)
    {
        $extra = Extra::where(['id' => $id])->first();
        $data = compact('extra');
        return view('admin.pages.hotel_panel.extra.edit_extra', $data);
    }

    public function br2nl($string){
        return preg_replace('#<br\s*/?>#i', "", $string);
    }

    public function store(request $request)
    {
        if ($request->isMethod('post')) {
            if (empty($request->id)) {
                $rules = array(
                    'name' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'price' => 'required',
                    'unit' => 'required',
                    /*'description' => 'required',*/
                );
            } else {
                $rules = array(
                    'name' => 'required',
                    'price' => 'required',
                    'unit' => 'required',
                    /*'description' => 'required',*/
                );
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $Extra = Extra::where(['id' => $request->id])->first();
        if (empty($Extra)) {
            $Extra = new Extra;
        }

        $hotel_id = Auth::guard('admin')->user()->hotel_id;
        $Extra->hotel_id = $hotel_id;
        $Extra->name = $request->name;
        $Extra->name_it = $request->name_it;
        $Extra->name_de = $request->name_de;
        $Extra->name_fr = $request->name_fr;
        $Extra->name_es = $request->name_es;

        $Extra->price = $request->price;

        $Extra->child_age1_rate = $request->child_age1_rate;
        $Extra->child_age2_rate = $request->child_age2_rate;
        $Extra->child_age3_rate = $request->child_age3_rate;

        $Extra->unit = $request->unit;
        $Extra->description = nl2br(self::br2nl($request->description));
        $Extra->description_it = nl2br(self::br2nl($request->description_it));
        $Extra->description_de = nl2br(self::br2nl($request->description_de));
        $Extra->description_fr = nl2br(self::br2nl($request->description_fr));
        $Extra->description_es = nl2br(self::br2nl($request->description_es));

        $Extra->is_mandatory = 0;
        if(isset($request->is_mandatory) && !empty($request->is_mandatory)) {
            $Extra->is_mandatory = 1;
        }

        if ($request->file('image') != '') {
            $image_path = url('public/images/extra/' . $request->image);

            if (file_exists($image_path)) {
                File::delete($image_path);
            }

            $imageName = time() . '_extra' . '.' . request()->image->guessClientExtension();
            $upload_path = 'public/images/extra/';

            request()->image->move($upload_path, $imageName);
            $Extra->image = $imageName;
        }

        $Extra->save();

        return redirect()->back()->with('success', 'Extra successfully uploaded');
    }

    public function delete($id)
    {
        $extra = Extra::where(['id' => $id])->first();
        $extra->delete();
        return redirect()->back()->with('success', 'Extra successfully deleted');
    }
}
