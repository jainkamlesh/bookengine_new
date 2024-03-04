<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Currency;
use App\heplers\helper;

class CurrencyController extends Controller
{
    public function index()
    {
    	$currency =  Currency::orderBy('id', 'DESC')->Paginate(10);
        $currencyCnt =  $currency->count();
    	$data           = compact('currency','currencyCnt');
    	return view('admin.pages.currency.index', $data);
    }

    public function add()
    {
    	return view('admin.pages.currency.add_currency');
    }

    public function edit($id)
    {
    	$currency = Currency::where(['id' => $id])->first();
    	$data        = compact('currency');
    	return view('admin.pages.currency.edit_currency', $data);
    }


    public function store(request $request)
    {

    	if($request->isMethod('post'))
       	{
            $rules = array(
                'name'        => 'required',
                'code'  => 'required',
                'symbol'  => 'required',
                );
         	

	        $validator = Validator::make($request->all(), $rules);
	        if($validator->fails())
	        {
	            return redirect()->back()->withErrors($validator)->withInput();
	       	}
       	}

       	$Currency = Currency::where(['id' => $request->id])->first();
       	if(empty($Currency))
       	{
       		$Currency = new Currency;
       	}

        $Currency->name        = $request->name;
        $Currency->code   	   = $request->code; 
        $Currency->symbol      = $request->symbol; 
        $Currency->save();

        return redirect()->back()->with('success', 'Currency successfully uploaded');
    }

    public function delete($id)
    {
    	$Currency = Currency::where(['id' => $id])->first();
    	$Currency->delete();
    	return redirect()->back()->with('success', 'Currency successfully deleted');
    }
}
