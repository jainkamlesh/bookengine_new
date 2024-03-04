<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    public function index()
    {
        $sitesetting = SiteSetting::find(current_site_ID());
        $data        = compact('sitesetting');
        return  view('admin.pages.site_setting.index', $data);
    }

    public function savesiteSetting(request $request)
    {
        $sitesetting = SiteSetting::find(current_site_ID());

        if($request->file('site_logo')!='')
        {
            $image_path = url('public/site/'.$request->site_logo);

            if (file_exists($image_path)) 
            {
               File::delete($image_path);
            }
            
            $imageName          = time().'_logo'.'.'.request()->site_logo->guessClientExtension();
            $upload_path        = 'public/site/';
            request()->site_logo->move($upload_path, $imageName);
            $sitesetting->site_logo  = $imageName;
        }

        $sitesetting->site_name            = $request->sitename;
        $sitesetting->site_heading         = $request->siteheading;
        $sitesetting->tag_line             = $request->tagline;
        $sitesetting->contact_heading      = $request->contact_heading;
        $sitesetting->contact_tag_line     = $request->contact_tagline;
        $sitesetting->site_phone           = $request->contact;
        $sitesetting->site_email           = $request->email; 
        $sitesetting->site_address         = $request->address;
        $sitesetting->footer_aboutus       = $request->footer_aboutus;
        $sitesetting->testimonial_heading  = $request->testimonial_heading;
        $sitesetting->ourteam_heading      = $request->ourteam_heading;
        $sitesetting->title_tag            = $request->title_tag;
        $sitesetting->description_tag      = $request->description_tag;
        $sitesetting->robots_tag           = $request->robots_tag;
        $sitesetting->alt_text             = $request->alt_text;
        $sitesetting->canonical_tag        = $request->canonical_tag;
        $sitesetting->save();

        return redirect()->back();
    }

}
