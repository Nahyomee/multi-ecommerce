<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses;
        $shipping_method = ShippingRule::where('status', 1)->get();
        return view('frontend.checkout', compact('addresses', 'shipping_method'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_method' => ['required', 'integer'],
            'shipping_address_id' => ['required', 'integer'],
        ]);

        $shipping_method = ShippingRule::findOrFail($request->shipping_method);
        Session::put('shipping_method', [
            'id' => $shipping_method->id,
            'name' => $shipping_method->name,
            'type' => $shipping_method->type,
            'cost' => $shipping_method->cost
        ]);
        $address = UserAddress::findOrFail($request->shipping_address_id)->toArray();
        Session::put('shipping_address', $address);
        
        return response(['status' => 'success', 'redirect_url' => route('payment')]);
    }

   
}
