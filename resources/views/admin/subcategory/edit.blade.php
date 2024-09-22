@extends('admin.layouts.master')

@section('title', 'Edit Sub Category')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Edit Sub Category</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.subcategories.index')}}">Sub Categories</a></div>
        <div class="breadcrumb-item active">Edit Sub Category</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Edit Sub Category</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Edit Sub Category</h4>
              <div class="card-header-action">
                  <a href="{{route('admin.subcategories.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New </a>

              </div>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('admin.subcategories.update', ['subcategory' => $subcategory])}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>Category</label>
                      <select name="category" class="form-control">
                        <option value="">Select</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" @selected(old('category', $subcategory->category_id) == $category->id)>{{$category->name}}</option>
                        @endforeach
                      </select>
                      @error('category')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{old('name', $subcategory->name)}}" class="form-control">
                        @error('name')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option value="1" @selected(old('status', $subcategory->status) == '1') >Active</option>
                          <option value="0" @selected(old('status',$subcategory->status) == '0')>Inactive</option>
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