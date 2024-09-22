@extends('admin.layouts.master')

@section('title', $variant->name.' Items')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>{{$variant->name}} Items</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.products.variants.index', ['product' => $variant->product])}}">{{$variant->product->name}} Variants</a></div>
        <div class="breadcrumb-item active">{{$variant->name}} Items</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">{{$variant->name}} Items</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4> {{$variant->name}} Items </h4>
              <div class="card-header-action">
                <a href="{{route('admin.variants.items.create', ['variant' => $variant])}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New </a>
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
            url : '{{route('admin.variants.items.change-status')}}',
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