@extends('admin.layouts.master')

@section('title', 'Transactions')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Transactions</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item">Transactions</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Transactions</h2>
      <p class="section-lead">All Transactions.</p>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>All Transactions</h4>
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

@endpush