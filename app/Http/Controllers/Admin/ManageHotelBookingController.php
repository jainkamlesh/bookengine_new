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

class ManageHotelBookingController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        return view('booking_form', $data);
    }

    public function saveData(Request $request) {

        $data_post = $request->all();
        dd($data_post);
    }
}