@extends('admin.layouts.master')

@section('title', 'Create Slider')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Create Slider</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.sliders.index')}}">Sliders</a></div>
        <div class="breadcrumb-item">Create Slider</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Create Slider</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Create Slider</h4>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('admin.sliders.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Type</label>
                        <input type="text" name="type" value="{{old('type')}}" placeholder="New Arrival, Latest deal etc" class="form-control">
                        @error('type')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{old('title')}}" placeholder="Men's Fashion" class="form-control">
                        @error('title')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Starting Price</label>
                        <input type="number" name="starting_price" value="{{old('starting_price')}}" class="form-control">
                        @error('starting_price')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="url" name="url" value="{{old('url')}}" class="form-control">
                        @error('url')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="button_text" value="{{old('button_text')}}" class="form-control">
                        @error('button_text')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Serial <small class="text-info">The order of the slider</small></label>
                        <input type="number" name="serial" value="{{old('serial')}}" class="form-control">
                        @error('serial')
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
                    <div class="form-group">
                        <label>Slider</label>
                        <input type="file" name="slider" class="form-control">
                        @error('slider')
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