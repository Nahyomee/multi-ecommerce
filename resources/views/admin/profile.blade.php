@extends('admin.layouts.master')

@section('title', 'Profile')
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
        </div>
        <div class="section-body">
        <h2 class="section-title">Hi, {{auth()->user()->name}}!</h2>
        <p class="section-lead">
            Change information about yourself on this page.
        </p>

        <div class="row mt-sm-4">
            <div class="col-12">
                @include('flash-message')
            <div class="card">
                <form method="post" class="needs-validation" action="{{route('admin.profile')}}" enctype="multipart/form-data">
                    @csrf
                <div class="card-header">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row">                               
                        <div class="form-group col-md-6 col-12">
                            <label> Name</label>
                            <input type="text" name="name" class="form-control" value="{{old('name',auth()->user()->name)}}" required="">
                            @error('name')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{old('email', auth()->user()->email)}}" required="">
                            @error('email')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                            @error('file')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Save Changes</button>
                </div>
                </form>
            </div>

            <div class="card">
                <form method="post" class="needs-validation" action="{{route('admin.password.update')}}" >
                    @csrf
                <div class="card-header">
                    <h4>Update Password</h4>
                </div>
                <div class="card-body">
                    <div class="row"> 
                        <div class="form-group col-12">
                            <label> Current Password</label>
                            <input type="password" name="current_password" class="form-control" required="">
                            @error('current_password')
                                <code>{{$message}}</code>
                            @enderror
                        </div>                              
                        <div class="form-group col-md-6 col-12">
                            <label> New Password</label>
                            <input type="password" name="password" class="form-control" required="">
                            @error('password')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required="">
                          
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Save Changes</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>
    </section>
@endsection