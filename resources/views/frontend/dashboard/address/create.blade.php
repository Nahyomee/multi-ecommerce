@extends('frontend.dashboard.layouts.master')
@section('title', 'Create Address')

@section('content')

<div class="row">
    <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
      <div class="dashboard_content mt-2 mt-md-0">
        <h3><i class="fal fa-house"></i>create address</h3>
        <div class="wsus__dashboard_add wsus__add_address">
          <form method="post" action="{{route('user.address.store')}}">
            @csrf
            <div class="row">
              <div class="col-xl-6 col-md-6">
                <div class="wsus__add_address_single">
                  <label>name <b>*</b></label>
                  <input type="text" name="name" value="{{old('name', auth()->user()->name)}}" placeholder="Name">
                </div>
                @error('name')
                <code>{{$message}}</code>
              @enderror
              </div>
              <div class="col-xl-6 col-md-6">
                <div class="wsus__add_address_single">
                  <label>email</label>
                  <input type="email" name="email" value="{{old('email', auth()->user()->email)}}" placeholder="Email">
                </div>
                @error('email')
                <code>{{$message}}</code>
              @enderror
              </div>
              <div class="col-xl-6 col-md-6">
                <div class="wsus__add_address_single">
                  <label>phone <b>*</b></label>
                  <input type="text" name="phone" value="{{old('phone')}}" placeholder="Phone">
                </div>
                @error('phone')
                <code>{{$message}}</code>
              @enderror
              </div>
              <div class="col-xl-6 col-md-6">
                <div class="wsus__add_address_single">
                  <label>country <b>*</b></label>
                  <div class="wsus__topbar_select">
                    <select class="select_2 country_name" name="country">
                      <option value="">Select Country</option>
                      @foreach (config('settings.countries') as $key => $country)
                        <option id="{{$key}}" value="{{$country}}" @selected(old('country') == $country)>{{$country}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @error('country')
                <code>{{$message}}</code>
              @enderror
              </div>
              <div class="col-xl-6 col-md-6">
                <div class="wsus__add_address_single">
                  <label>state <b>*</b></label>
                  <input type="text" name="state" value="{{old('state')}}" placeholder="State">
                </div>
                @error('state')
                <code>{{$message}}</code>
              @enderror
              </div>
              <div class="col-xl-6 col-md-6">
                <div class="wsus__add_address_single">
                  <label>city <b>*</b></label>
                  <input type="text" name="city" value="{{old('city')}}" placeholder="City">
                </div>
                @error('city')
                <code>{{$message}}</code>
                @enderror
              </div>
              <div class="col-xl-6 col-md-6">
                <div class="wsus__add_address_single">
                  <label>zip code <b>*</b></label>
                  <input type="text" name="zip_code" value="{{old('zip_code')}}" placeholder="Zip Code">
                </div>
                @error('zip_code')
                <code>{{$message}}</code>
                @enderror
              </div>
              <div class="col-xl-6 col-md-6">
                <div class="wsus__add_address_single">
                  <label>Address</label>
                  <input type="text" name="address" value="{{old('address')}}" placeholder="Address">
                </div>
                @error('address')
                <code>{{$message}}</code>
                @enderror
              </div>
              <div class="col-xl-6">
                <button type="submit" class="common_btn">create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endsection