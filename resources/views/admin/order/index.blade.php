@extends('admin.layouts.master')

@section('title', 'Orders')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Orders</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item">Orders</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Orders</h2>
      <p class="section-lead">All Orders.</p>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>All Orders</h4>
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
      })
    </script>
@endpush