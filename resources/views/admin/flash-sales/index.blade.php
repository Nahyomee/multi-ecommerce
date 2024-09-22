@extends('admin.layouts.master')

@section('title', 'Flash Sales')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Flash Sales</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item active">Flash Sales</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Flash Sales</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Flash Sale End Date</h4>
            </div>
            <div class="card-body">
              <form action="{{route('admin.flash-sales.update')}}" method="post">
                @method('PUT')
                @csrf
                <div class="">
                  <div class="form-group">
                    <label>Sale End Date</label>
                    <input type="text" name="end_date" value="{{$flashSale?->end_date}}" class="form-control datepicker">
                    @error('end_date')
                        <code>{{$message}}</code>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <button class="btn btn-primary" type="submit">Submit</button>
                  <button class="btn btn-secondary" type="reset">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    <div class="row">
      <div class="col-12 ">
        <div class="card">
          <div class="card-header">
            <h4>Add Flash Sale Items</h4>
          </div>
          <div class="card-body">
            <form action="{{route('admin.flash-sales.add-product')}}" method="post">
              @csrf
              <div>
                <div class="form-group">
                  <label>Sale End Date</label>
                  <select name="product" class="form-control select2">
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                      <option value="{{$product->id}}"  @selected(old('product') == $product->id)>{{$product->name}}</option>
                    @endforeach
                  </select>
                  @error('product')
                      <code>{{$message}}</code>
                  @enderror
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Show at homepage?</label>
                      <select name="home" class="form-control">
                      <option value="">Select</option>
                        <option value="1" @selected(old('home') == '1') >Yes</option>
                        <option value="0" @selected(old('home') == '0')>No</option>
                      </select>
                      @error('home')
                          <code>{{$message}}</code>
                      @enderror
                  </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control">
                        <option value="">Select</option>
                        <option value="1" @selected(old('status') == '1') >Active</option>
                        <option value="0" @selected(old('status') == '0')>Inactive</option>
                      </select>
                      @error('status')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-secondary" type="reset">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Flash Sales Products</h4>
              <div class="card-header-action">
                  <a href="{{route('admin.products.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New </a>
              </div>
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
            url : '{{route('admin.flash-sales.change-status')}}',
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

        $('body').on('click', '.change-home-status', function(){
          let id = $(this).attr('data-id') // or $(this).data('id')
          let isChecked = $(this).is(':checked')

          $.ajax({
            url : '{{route('admin.flash-sales.change-home-status')}}',
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