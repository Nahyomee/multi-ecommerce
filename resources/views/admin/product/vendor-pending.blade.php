@extends('admin.layouts.master')

@section('title', 'Pending Vendor Products')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Pending Vendor Products</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item active">Pending Vendor Products</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">PendingVendor Products</h2>
      <p class="section-lead">All pending vendor products.</p>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
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
            url : '{{route('admin.vendors.products.change-status')}}',
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

        //change approved status
        $('body').on('change', '.is-approved', function(){
          let id = $(this).attr('data-id') // or $(this).data('id')
          let value = $(this).val()
          $.ajax({
            url : '{{route('admin.vendors.products.approve')}}',
            method : 'PUT',
            data : {
              value : value,
              id : id
            },
            success: function(data){
              if(data.status == 'success'){
                    toastr.success(data.message)
                    window.location.reload()
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