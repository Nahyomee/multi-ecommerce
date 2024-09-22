@extends('admin.layouts.master')

@section('title', 'Child Categories')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Child Categories</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item">Child Categories</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Child Categories</h2>
      <p class="section-lead">All child categories.</p>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Child Categories</h4>
              <div class="card-header-action">
                  <a href="{{route('admin.child-categories.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New </a>

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
            url : '{{route('admin.child-categories.change-status')}}',
            method : 'PUT',
            data : {
              status : isChecked,
              id : id
            },
            success: function(data){
              if(data.status == 'success'){
                    toastr.success(data.message)
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