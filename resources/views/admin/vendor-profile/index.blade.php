@extends('admin.layouts.master')

@section('title', 'Vendor Profile')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Vendor Profile</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item active">Vendor Profile</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Vendor Profile</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Vendor Profile</h4>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('admin.vendor-profile.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label>Preview</label><br>
                      <img  width="200px" src="{{asset('vendors/'.$profile->banner)}}">
                  </div>
                    <div class="form-group">
                        <label>Banner</label>
                        <input type="file" name="banner" class="form-control">
                        @error('banner')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label>Shop Name</label>
                      <input type="text" name="shop_name" value="{{old('shop_name', $profile?->shop_name)}}" class="form-control">
                      @error('shop_name')
                          <code>{{$message}}</code>
                      @enderror
                  </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" value="{{old('email', $profile->email)}}" class="form-control">
                      @error('email')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="tel" name="phone" value="{{old('phone', $profile->phone)}}" class="form-control">
                      @error('phone')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <textarea name="address" class="form-control">{{old('address', $profile->address)}}</textarea>
                      @error('address')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Description</label>
                      <textarea name="description" class="summernote">{{old('description', $profile->description)}}</textarea>
                      @error('description')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Facebook Link</label>
                      <input type="url" name="facebook" placeholder="https://web.facebook.com/username" value="{{old('facebook', $profile->facebook)}}" class="form-control">
                      @error('facebook')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Twitter Link</label>
                      <input type="url" name="twitter" placeholder="https://x.com/username" value="{{old('twitter', $profile->twitter)}}" class="form-control">
                      @error('twitter')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Instagram Link</label>
                      <input type="url" name="instagram" placeholder="https://instagram.com/username" value="{{old('instagram', $profile->instagram)}}" class="form-control">
                      @error('instagram')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Whatsapp Link</label>
                      <input type="url" name="whatsapp" placeholder="https://wa.me/number" value="{{old('whatsapp', $profile->whatsapp)}}" class="form-control">
                      @error('whatsapp')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <button class="btn btn-primary mr-1" type="submit">Update</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                </form>
                 
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection