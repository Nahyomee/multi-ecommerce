@extends('vendor.layouts.master')

@section('title', 'Create Variant')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Create Variant</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('vendor.products.index')}}">Products</a></div>
        <div class="breadcrumb-item"><a href="{{route('vendor.products.variants.index', ['product' => $product])}}">{{$product->name}} Variants</a></div>
        <div class="breadcrumb-item active">Create Variant</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Create Variant</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Create Variant</h4>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('vendor.products.variants.store', ['product' => $product])}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control">
                        @error('name')
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