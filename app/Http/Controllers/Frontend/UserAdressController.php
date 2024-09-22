<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAdressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('frontend.dashboard.address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.dashboard.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required', 'string'],
            'zip_code' => ['required'],
            'address' => ['required']
        ]);

        $address = auth()->user()->addresses()->create($request->all());

        if($address){
            return back()->with('success', 'Address Created!');
        }
        return back()->with('error', 'Address not Created!');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserAddress $address)
    {
        return view('frontend.dashboard.address.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $address)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required', 'string'],
            'zip_code' => ['required'],
            'address' => ['required']
        ]);

        if($address->update($request->all())){
            return back()->with('success', 'Address Updated!');
        }
        return back()->with('error', 'Address not Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $address)
    {
        if($address->delete()){
            return response(['status' => 'success', 'message' => 'Address Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Address not Deleted!']);
    }
}
