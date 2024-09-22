<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\Http\Controllers\Controller;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopProfileController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = auth()->user()->vendor;
        return view('vendor.shop-profile.index', compact('profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => ['required', 'string', 'max:200'],
            'banner' => ['nullable', 'image', 'max:2048'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'max:15'],
            'address' => ['required'],
            'description' => ['required'],
            'facebook' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'whatsapp' => ['nullable', 'url'],
        ]);
        $profile = auth()->user()->vendor;
        if($profile->update($request->except('banner'))){
            $oldPath = 'vendors/'.$profile->banner;
            $filename = Str::slug(auth()->user()->name).rand(10,99);
            $banner = $this->updateImage($request, $filename, 'vendors', $oldPath, 'banner');
            if($banner != null){
                $profile->banner = $banner;
                $profile->save(); 
            }
            return back()->with('success', 'Vendor Profile Updated!');
        }
        else{
            return back()->with('error', 'Vendor Profile not Updated!');
        }
    }

}
