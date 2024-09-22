@extends('admin.layouts.master')

@section('title', $product->name.' Images')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Product Images</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products</a></div>
        <div class="breadcrumb-item active">{{$product->name}} Images</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Product Images</h2>
      <p class="section-lead">All {{$product->name}} images.</p>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Upload Image(s)</h4>
            </div>
            <div class="card-body">
              @include('flash-message')
              <form method="post" action="{{route('admin.products.images.store', ['product' => $product])}}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                      <label for="image">Image<code>(Multiple Images Supported)</code></label>
                      <input type="file" name="image[]" multiple class="form-control">
                      @error('image')
                          <code>{{$message}}</code>
                      @enderror
                  </div>
                  <button class="btn btn-primary" type="submit">Upload</button>
              </form>
            </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>{{$product->name}} Images</h4>
            </div>
            <div class="card-body">
              {{$dataTable->table()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
      $(document).ready(function(){
        $('body').on('click', '.change-status', function(){
          let id = $(this).attr('data-id') // or $(this).data('id')
          let isChecked = $(this).is(':checked')

          $.ajax({
            url : '{{route('vendor.variants.items.change-status')}}',
            method : 'PUT',
            data : {
              status : isChecked,
              id : id
            },
            success: function(data){
              if(data.status == 'success'){
                    toastr.success(data.message)
                    //window.location.reload()
                  }
                  if(data.status == 'error'){
                    toastr.error(data.message)

                  }
            },
            error: function(xhr, status, error){
              toastr.error('Error changing status')
            }
          })
        })
      })
    </script>
@endpush