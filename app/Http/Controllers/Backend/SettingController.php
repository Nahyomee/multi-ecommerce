<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Settings Page.
     */
    public function index()
    {
        $general_settings = GeneralSetting::first();
        return view('admin.settings.index', compact('general_settings'));
    }

    /**
     * Update general settings.
     */
    public function generalSettingsUpdate(Request $request)
    {
        $request->validate([
            'site_name' => ['required', 'max:200'],
            'layout' => ['required', 'in:ltr,rtl'],
            'contact_email' => ['required', 'email'],
            'currency' => ['required', 'max:5'],
            'currency_icon' => ['required'],
            'timezone' => ['required']
        ]);

        $setting = GeneralSetting::updateOrCreate(['id' => 1], $request->all());

        if($setting){
            return back()->with('success', 'General Setting Updated!');
        }
        else{
            return back()->with('error', 'General Setting not Updated!');

        }
    }


   
}
