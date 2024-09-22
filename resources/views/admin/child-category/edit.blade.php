@extends('admin.layouts.master')

@section('title', 'Edit Child Category')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Edit Child Category</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.child-categories.index')}}">Child Categories</a></div>
        <div class="breadcrumb-item active">Edit Child Category</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Edit Child Category</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Edit Child Category</h4>
              <div class="card-header-action">
                  <a href="{{route('admin.child-categories.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New </a>

              </div>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('admin.child-categories.update', ['child_category' => $child_category])}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>Category</label>
                      <select name="category" class="form-control main-category">
                        <option value="">Select</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" @selected(old('category', $child_category->category_id) == $category->id)>{{$category->name}}</option>
                        @endforeach
                      </select>
                      @error('category')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Sub Category</label>
                      <select name="subcategory" class="form-control sub-category">
                        <option value="">Select</option>
                        @foreach ($subcategories as $subcategory)
                        <option value="{{$subcategory->id}}" @selected(old('subcategory', $child_category->sub_category_id) == $subcategory->id)>{{$subcategory->name}}</option>
                        @endforeach
                      </select>
                      @error('subcategory')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{old('name', $child_category->name)}}" class="form-control">
                        @error('name')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option value="1" @selected(old('status', $child_category->status) == '1') >Active</option>
                          <option value="0" @selected(old('status',$child_category->status) == '0')>Inactive</option>
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
@push('scripts')
  <script>
    $(document).ready(function(){
      $('body').on('change', '.main-category', function (e){
        let id = $(this).val()
        $.ajax({
          method:'GET',
          url: "{{route('admin.get-subcategories')}}",
          data: {
            id : id
          },
          success: function(data){
            $('.sub-category').html(`<option value="">Select</option> `)
            $.each(data, function(i, item){
              $('.sub-category').append(`<option value="${item.id}">${item.name}</option> `)

            })
          },
          error: function(xhr, status, error){
            toastr.error(error)
          }
        })
      })
    })
  </script>
@endpush