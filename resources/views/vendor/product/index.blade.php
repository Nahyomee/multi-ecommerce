@extends('vendor.layouts.master')

@section('title', 'Products')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Products</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item active">Products</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Products</h2>
      <p class="section-lead">All products.</p>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Products</h4>
              <div class="card-header-action">
                  <a href="{{route('vendor.products.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New </a>
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
            url : '{{route('vendor.products.change-status')}}',
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