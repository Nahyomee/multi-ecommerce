@extends('admin.layouts.master')

@section('title', '#'.$order->invoice_id)

@section('content')
<section class="section">
    <div class="section-header">
      <h1>#{{$order->invoice_id}}</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.orders.index')}}">Orders</a></div>
        <div class="breadcrumb-item">Order #{{$order->invoice_id}}</div>
      </div>
    </div>
    @php
      $coupon_cost = 0;
      if($coupon?->discount_type == "percentage"){
        $coupon_cost = $coupon->discount * $order->sub_total / 100;
      }elseif($coupon?->discount_type == "flat_fee"){
        $coupon_cost = $coupon->discount;
      }
    @endphp
    <div class="section-body">
      <div class="invoice">
        <div class="invoice-print">
          <div class="row">
            <div class="col-lg-12">
              <div class="invoice-title">
                <h2>Invoice</h2>
                <div class="invoice-number">Order #{{$order->invoice_id}}</div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <address>
                    <strong>Billed To:</strong><br>
                      <b>Name: </b> {{$address->name}}<br>
                      <b>Email: </b> {{$address->email}}<br>
                      <b>Phone: </b>{{$address->phone}}<br>
                      <b>Address: </b>{{$address->address}}<br>
                      {{$address->city}}, {{$address->zip_code}}<br>
                      {{$address->state}}, {{$address->country}}
                  </address>
                </div>
                <div class="col-md-6 text-md-right">
                  <address>
                    <strong>Shipped To:</strong><br>
                    {{$address->name}}<br>
                    {{$address->email}}<br>
                    {{$address->phone}}<br>
                    {{$address->address}}<br>
                    {{$address->city}}, {{$address->zip_code}}<br>
                    {{$address->state}}, {{$address->country}}
                  </address>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <address>
                    <strong>Payment Information:</strong><br>
                    <b>Method: </b>{{ucfirst($order->payment_method)}}<br>
                    <b>Transaction ID: </b>{{$order->transaction->transaction_id}}<br>
                    <b>Status: </b>{{ucfirst($order->payment_status)}}<br>
                  </address>
                </div>
                <div class="col-md-6 text-md-right">
                  <address>
                    <strong>Order Date:</strong><br>
                    {{date('F j, Y', strtotime($order->created_at))}}<br><br>
                  </address>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="section-title">Order Summary</div>
              <p class="section-lead">All items here cannot be deleted.</p>
              <div class="table-responsive">
                <table class="table table-striped table-hover table-md">
                  <tr>
                    <th data-width="40">#</th>
                    <th>Item</th>
                    <th>Variant(s)</th>
                    <th class="text-center">Vendor</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Totals</th>
                  </tr>
                  @foreach ($order->items as $key => $item)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td><a target="_blank" href="{{route('product', ['product' => $item->product])}}">{{$item->product_name}}</a></td>
                      <td>
                        @forelse (json_decode($item->variants) as $key => $variant )
                          <b>{{$key}}:</b> {{$variant->name}}
                        @empty
                          <b> - </b>
                        @endforelse
                      </td>
                      <td class="text-center">{{$item->vendor->shop_name}}</td>
                      <td class="text-center">{{$order->currency_icon}}{{$item->unit_price}}</td>
                      <td class="text-center">{{$item->quantity}}</td>
                      <td class="text-right">{{$order->currency_icon}}{{number_format($item->unit_price * $item->quantity,2)}}</td>
                    </tr>
                    
                  @endforeach
                </table>
              </div>
              <div class="row mt-4">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="order_status">Order Status</label>
                    <select name="order_status" id="order_status" data-id="{{$order->id}}" class="form-control">
                      @foreach (config('order-status.order_status_admin') as $key => $status)
                        <option value="{{$key}}" @selected(old('order_status', $order->status) == $key)>
                          {{$status['status']}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-8 text-right">
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Subtotal</div>
                    <div class="invoice-detail-value">{{$order->currency_icon}}{{$order->sub_total}}</div>
                  </div>
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Coupon(-)</div>
                    <div class="invoice-detail-value">{{$order->currency_icon}}{{number_format($coupon_cost,2)}}</div>
                  </div>
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Shipping(+)</div>
                    <div class="invoice-detail-value">{{$order->currency_icon}}{{number_format($shipping->cost,2)}}</div>
                  </div>
                  <hr class="mt-2 mb-2">
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Total</div>
                    <div class="invoice-detail-value invoice-detail-value-lg">{{$order->currency_icon}}{{number_format($order->amount,2)}}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="text-md-right">
         
          <button class="btn btn-warning btn-icon icon-left print-invoice"><i class="fas fa-print"></i> Print</button>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script>
    $(document).ready(function(){
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
        $('#order_status').on('change', function(){
            let status = $(this).val()
            
            $.ajax({
                method: 'post',
                url: '{{route('admin.orders.change-status')}}',
                data: {
                  status: status,
                  id: $(this).data('id')
                },
                success: function(data){
                  if(data.status == "success"){
                    toastr.success(data.message)
                  }
                  else{
                    toastr.error(data.message)
                  }
                },
                error: function(data){
                  console.log(data)
                  toastr.error(data.statusText)

                }
            })
        })

        $('.print-invoice').on('click', function(){
            let printBody = $('.invoice-print')
            let originalContent = $('body').html()
            $('body').html(printBody.html())

            window.print()

            $('body').html(originalContent)
        })
    })
  </script>
@endpush