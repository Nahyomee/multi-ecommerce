<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
    //

    /**
     * Index
     */

    public function dashboard() : View
    {
    return view('frontend.dashboard.dashboard');

    }

    /**
     * Profile
     */

    public function profile() : View
    {
        return view('frontend.dashboard.profile');
    }

    /** 
     * Update profile
     */

     public function updateProfile(Request $request) 
     {
         $request->validate([
             'name' => ['required', 'string'],
             'email' => ['required', 'email', 'unique:users,email,'.auth()->user()->id],
             'image' => ['image', 'max:2048']
         ]);
 
         $user = User::find(auth()->user()->id);
         if($request->hasFile('image')){
             if(File::exists(public_path('uploads/'.$user->image))){
                 File::delete(public_path('uploads/'.$user->image));
             }
             $image = $request->image;
             $filename = $user->name.rand().'.'.$image->getClientOriginalExtension();
             $image->move(public_path('uploads'), $filename);
             $user->image = $filename;
         }
         $user->name = $request->name;
         $user->email = $request->email;
         if($user->save()){
             if($user->wasChanged('email')){
                 $user->email_verified_at = null;
             }
             return back()->with('success', 'Profile updated!');
         }
         return back()->with('error', 'Profile not updated!');
 
     }
 
     /**
      * Update password
      */
 
    public function updatePassword(Request $request) 
    {
        $request->validate([
            'current_password' => ['required',  'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);
        toastr()->success('Password updated!');

        return back();

    }
}
