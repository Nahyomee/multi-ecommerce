@extends('vendor.layouts.master')

@section('title', 'Edit '.$variant->name.' Item')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Edit {{$variant->name}} Item</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('vendor.variants.items.index', ['variant' => $variant])}}">{{$variant->name}} Items</a></div>
        <div class="breadcrumb-item active">Edit {{$variant->name}} Item</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Edit Item</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Edit Variant Item</h4>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('vendor.variants.items.update', ['variant' => $variant, 'item' => $item])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" name="name" value="{{old('name', $item->name)}}" class="form-control">
                        @error('name')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label>Price <code>(Set 0 if free)</code></label>
                      <input type="number" name="price" value="{{old('price', $item->price)}}" class="form-control">
                      @error('price')
                          <code>{{$message}}</code>
                      @enderror
                  </div>
                    <div class="form-group">
                      <label>Default?</label>
                      <select name="is_default" class="form-control">
                        <option value="">Select</option>
                        <option value="1" @selected(old('is_default', $item->is_default) == '1') >Yes</option>
                        <option value="0" @selected(old('is_default', $item->is_default) == '0')>No</option>
                      </select>
                      @error('is_default')
                          <code>{{$message}}</code>
                      @enderror
                  </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option value="1" @selected(old('status', $item->status) == '1') >Active</option>
                          <option value="0" @selected(old('status', $item->status) == '0')>Inactive</option>
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