@extends('admin.layouts.master')

@section('title', 'Create Brand')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Create Brand</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.brands.index')}}">Brands</a></div>
        <div class="breadcrumb-item">Create Brand</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Create Brand</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Create Brand</h4>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('admin.brands.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" name="logo" class="form-control">
                        @error('logo')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control">
                        @error('name')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="inputState" >Is Featured</label>
                        <select id="inputState" name="is_featured" class="form-control">
                          <option value="">Select</option>
                          <option value="1" @selected(old('is_featured') == '1') >Yes</option>
                          <option value="0" @selected(old('is_featured') == '0')>No</option>
                        </select>
                        @error('is_featured')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option value="1" @selected(old('status') == '1') >Active</option>
                          <option value="0" @selected(old('status') == '0')>Inactive</option>
                        </select>
                        @error('status')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                </form>
                 
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection