@extends('admin.layouts.master')

@section('title', 'Sliders')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Sliders</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item">Sliders</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Sliders</h2>
      <p class="section-lead">All sliders in the website.</p>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Sliders</h4>
              <div class="card-header-action">
                  <a href="{{route('admin.sliders.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New </a>

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
@endpush