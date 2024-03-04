<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\WhatsappTemplate;
use App\heplers\helper;
use Str;

class WhatsappTemplateController extends Controller
{
    public function index()
    {
        $whatsappTemplate = WhatsappTemplate::orderBy('id', 'DESC')->Paginate(10);
        $whatsappTemplateCnt = $whatsappTemplate->count();
        $data = compact('whatsappTemplate', 'whatsappTemplateCnt');

        return view('admin.pages.whatsapp_template.index', $data);
    }

    public function add()
    {
        return view('admin.pages.whatsapp_template.add_whatsapp_template');
    }

    public function edit($id)
    {
        $whatsappTemplate = WhatsappTemplate::where(['id' => $id])->first();
        $data = compact('whatsappTemplate');
        return view('admin.pages.whatsapp_template.edit_whatsapp_template', $data);
    }


    public function store(request $request)
    {
        if ($request->isMethod('post')) {
                $rules = array(
                    'name' => 'required',
                    'message' => 'required',
                );

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
        }

        $whatsappTemplate = WhatsappTemplate::where(['id' => $request->id])->first();
        if (empty($whatsappTemplate)) {
            $whatsappTemplate = new WhatsappTemplate();
        }
        $whatsappTemplate->name = $request->name;
        $whatsappTemplate->message = $request->message;
        $whatsappTemplate->save();
        return redirect()->back()->with('success', 'Whatsapp Template successfully uploaded');
    }

    public function delete($id)
    {
        $whatsappTemplate = WhatsappTemplate::where(['id' => $id])->first();
        $whatsappTemplate->delete();
        return redirect()->back()->with('success', 'Whatsapp Template successfully deleted');
    }
}
