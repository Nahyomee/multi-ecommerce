@extends('frontend.dashboard.layouts.master')
@section('title', 'Profile')

@section('content')
<div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
  <div class="dashboard_content mt-2 mt-md-0">
    <h3><i class="far fa-user"></i> profile</h3>
    <div class="wsus__dashboard_profile">
      <div class="wsus__dash_pro_area">
        <h4>basic information</h4>
        <form method="post" action="{{route('user.profile')}}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-md-2">
                    <div class="wsus__dash_pro_img">
                      <img src="{{auth()->user()->image ? asset('uploads/'.auth()->user()->image) :asset('frontend/images/ts-2.jpg')}}" alt="img" class="img-fluid w-100">
                      <input type="file" name="image">
                    </div>
                    @error('image')
                    <code>{{$message}}</code>
                  @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl-6 col-md-6">
                    <div class="wsus__dash_pro_single">
                      <i class="fas fa-user-tie"></i>
                      <input name="name" value="{{old('name', auth()->user()->name)}}" type="text" placeholder="Name">
                    </div>
                    @error('name')
                      <code>{{$message}}</code>
                    @enderror
                  </div>
                  <div class="col-xl-6 col-md-6">
                    <div class="wsus__dash_pro_single">
                      <i class="fal fa-envelope-open"></i>
                      <input type="email" name="email" value="{{old('email', auth()->user()->email)}}" placeholder="Email">
                    </div>
                    @error('email')
                    <code>{{$message}}</code>
                  @enderror
                  </div>
                </div>
              </div>
              <div class="col-xl-12">
                <button class="common_btn mb-4 mt-2" type="submit">update</button>
              </div>
          </form>
          <div class="wsus__dash_pass_change mt-2">
              <form method="post" action="{{route('user.password.update')}}">
                @csrf
              <div class="row">
                <h4>update password</h4>
                <div class="col-xl-4 col-md-6">
                  <div class="wsus__dash_pro_single">
                    <i class="fas fa-unlock-alt"></i>
                    <input type="password" name="current_password" placeholder="Current Password">
                    
                  </div>
                </div>
                <div class="col-xl-4 col-md-6">
                  <div class="wsus__dash_pro_single">
                    <i class="fas fa-lock-alt"></i>
                    <input type="password" name="password" placeholder="New Password">
                  </div>
                </div>
                <div class="col-xl-4">
                  <div class="wsus__dash_pro_single">
                    <i class="fas fa-lock-alt"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password">
                  </div>
                </div>
                <div class="col-xl-12">
                  <button class="common_btn" type="submit">update password</button>
                </div>
              </div>
            </form>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection