@extends('admin.layouts.master')

@section('title', 'Edit Category')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Edit Category</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">Categories</a></div>
        <div class="breadcrumb-item">Edit Category</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Edit Category</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Edit Category</h4>
              <div class="card-header-action">
                  <a href="{{route('admin.categories.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New </a>

              </div>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('admin.categories.update', ['category' => $category])}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{old('name', $category->name)}}" class="form-control">
                        @error('name')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Icon</label><br>
                        <button class="btn btn-primary" name="icon" data-icon="{{$category->icon}}" data-selected-class="btn-secondary" data-unselected-class="btn-danger" role="iconpicker"></button>
                        <br>
                        @error('icon')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option value="1" @selected(old('status', $category->status) == '1') >Active</option>
                          <option value="0" @selected(old('status',$category->status) == '0')>Inactive</option>
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