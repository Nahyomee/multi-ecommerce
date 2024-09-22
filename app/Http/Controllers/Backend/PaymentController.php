<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FlutterwaveSetting;
use App\Models\PaystackSetting;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        //dd(config('settings.flutterwave'));
        $paystack_settings = PaystackSetting::first();
        $flutterwave_settings = FlutterwaveSetting::first();
        return view('admin.payment-settings.index', compact('paystack_settings', 'flutterwave_settings'));
    }

    /** Update Paystack settings */
    public function updatePaystack(Request $request)
    {
        $request->validate([
            'currency' => ['required'],
            'rate' => ['required', 'numeric'],
            'secret_key' => ['required', 'string'],
            'public_key' => ['required', 'string'],
            'merchant_email' => ['nullable', 'email']
        ]);
        $setting = PaystackSetting::updateOrCreate(['id' => 1], $request->all());
        if($setting){
            return back()->with('success', 'Paystack Setting Updated!');
        }
        else{
            return back()->with('error', 'Paystack Setting not Updated!');

        }
    }

    /** Update Flutterwave settings */
    public function updateFlutterwave(Request $request)
    {
        $request->validate([
            'currency' => ['required'],
            'rate' => ['required', 'numeric'],
            'secret_key' => ['required', 'string'],
            'public_key' => ['required', 'string'],
            'encryption_key' => ['required', 'string'],
        ]);
        $setting = FlutterwaveSetting::updateOrCreate(['id' => 1], $request->all());
        if($setting){
            return back()->with('success', 'Flutterwave Setting Updated!');
        }
        else{
            return back()->with('error', 'Flutterwave Setting not Updated!');

        }
    }
}
