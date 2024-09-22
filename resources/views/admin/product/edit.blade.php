@extends('admin.layouts.master')

@section('title', 'Edit Product')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Edit Product</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products</a></div>
        <div class="breadcrumb-item">Edit Product</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Edit Product</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Edit Product</h4>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('admin.products.update', ['product' => $product])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>Preview</label><br>
                      <img  width="200px" src="{{asset('product/'.$product->thumb_img)}}">
                    </div>
                    <div class="form-group">
                        <label>Thumbnail</label>
                        <input type="file" name="thumb_img" class="form-control">
                        @error('thumb_img')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{old('name', $product->name)}}" class="form-control">
                        @error('name')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="inputState" >Category</label>
                          <select id="inputState" name="category" class="form-control main-category">
                            <option value="">Select</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" @selected(old('category', $product->category_id) == $category->id) >{{$category->name}}</option>
                            @endforeach
                           </select>
                          @error('category')
                              <code>{{$message}}</code>
                          @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="inputState" >Sub Category</label>
                          <select id="inputState" name="subcategory" class="form-control sub-category">
                            <option value="">Select</option>
                            @foreach ($subcategories as $subcategory)
                            <option value="{{$subcategory->id}}" @selected(old('subcategory', $product->subcategory_id) == $subcategory->id) >{{$subcategory->name}}</option>
                            @endforeach
                          </select>
                          @error('subcategory')
                              <code>{{$message}}</code>
                          @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="inputState" >Child Category</label>
                          <select id="inputState" name="child_category" class="form-control child-category">
                            <option value="">Select</option>
                            @foreach ($child_categories as $child_category)
                            <option value="{{$child_category->id}}" @selected(old('child_category', $product->child_category_id) == $child_category->id) >{{$child_category->name}}</option>
                            @endforeach
                          </select>
                          @error('child_category')
                              <code>{{$message}}</code>
                          @enderror
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputState" >Brand</label>
                    <select id="inputState" name="brand" class="form-control">
                      <option value="">Select</option>
                      @foreach ($brands as $brand)
                      <option value="{{$brand->id}}" @selected(old('brand', $product->brand_id) == $brand->id) >{{$brand->name}}</option>
                      @endforeach
                     </select>
                    @error('brand')
                        <code>{{$message}}</code>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="sku" value="{{old('sku', $product->sku)}}" class="form-control">
                    @error('sku')
                        <code>{{$message}}</code>
                    @enderror
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" value="{{old('price', $product->price)}}" class="form-control">
                        @error('price')
                            <code>{{$message}}</code>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Offer Price</label>
                        <input type="number" name="offer_price" value="{{old('offer_price', $product->offer_price)}}" class="form-control">
                        @error('offer_price')
                            <code>{{$message}}</code>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Offer Start Date</label>
                        <input type="text" name="offer_start" value="{{old('offer_start', $product->offer_start)}}" class="form-control datepicker">
                        @error('offer_start')
                            <code>{{$message}}</code>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Offer End Date</label>
                        <input type="text" name="offer_end" value="{{old('offer_end', $product->offer_end)}}" class="form-control datepicker">
                        @error('offer_end')
                            <code>{{$message}}</code>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" min="0" value="{{old('quantity', $product->quantity)}}" class="form-control">
                    @error('quantity')
                        <code>{{$message}}</code>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Video link</label>
                    <input type="url" name="video_link" value="{{old('video_link', $product->video_link)}}" class="form-control">
                    @error('video_link')
                        <code>{{$message}}</code>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Short Description</label>
                    <textarea name="short_desc" class="form-control">{{old('short_desc', $product->short_desc)}}</textarea>
                    @error('short_desc')
                        <code>{{$message}}</code>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Full Description</label>
                    <textarea name="description" class="form-control summernote">{{old('description', $product->description)}}</textarea>
                    @error('description')
                        <code>{{$message}}</code>
                    @enderror
                  </div>
                    <div class="form-group">
                      <label>Product Type</label>
                      <select name="product_type" class="form-control">
                        <option value="">Select</option>
                        <option value="new arrival" @selected(old('product_type', $product->product_type) == 'new arrival')>New Arrival</option>
                        <option value="featured product" @selected(old('product_type', $product->product_type) == 'featured product')>Featured Product</option>
                        <option value="top product" @selected(old('product_type', $product->product_type) == 'top product')>Top Product</option>
                        <option value="best product" @selected(old('product_type', $product->product_type) == 'best product')>Best Product</option>
                      </select>
                      @error('product_type')
                          <code>{{$message}}</code>
                      @enderror
                  </div>
                  <div class="form-group">
                    <label>Seo Title</label>
                    <input type="text" name="seo_title" value="{{old('seo_title', $product->seo_title)}}" class="form-control">
                    @error('seo_title')
                        <code>{{$message}}</code>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Seo Description</label>
                    <textarea name="seo_description" class="form-control">{{old('seo_description', $product->seo_description)}}</textarea>
                    @error('seo_description')
                        <code>{{$message}}</code>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                      <option value="1" @selected(old('status', $product->status) == '1') >Active</option>
                      <option value="0" @selected(old('status', $product->status) == '0')>Inactive</option>
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
      $('body').on('change', '.sub-category', function (e){
        let id = $(this).val()
        $.ajax({
          method:'GET',
          url: "{{route('admin.get-child-categories')}}",
          data: {
            id : id
          },
          success: function(data){
            $('.child-category').html(`<option value="">Select</option> `)
            $.each(data, function(i, item){
              $('.child-category').append(`<option value="${item.id}">${item.name}</option> `)

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