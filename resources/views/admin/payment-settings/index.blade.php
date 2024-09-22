@extends('admin.layouts.master')

@section('title', 'Payment Settings')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Payment Settings</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item">Payment Settings</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Payment Settings</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Settings</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                      <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-paystack-list" data-toggle="list" href="#list-paystack" role="tab">Paystack Settings</a>
                        <a class="list-group-item list-group-item-action" id="list-flutterwave-list" data-toggle="list" href="#list-flutterwave" role="tab">Flutterwave Settings</a>
                      </div>
                    </div>
                    <div class="col-8">
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-paystack" role="tabpanel" aria-labelledby="list-paystack-list">
                          @include('admin.payment-settings.paystack')
                        </div>
                        <div class="tab-pane fade" id="list-flutterwave" role="tabpanel" aria-labelledby="list-flutterwave-list">
                          @include('admin.payment-settings.flutterwave')
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script>
    $('.flutterwave-select2').select2()
  </script>
@endpush