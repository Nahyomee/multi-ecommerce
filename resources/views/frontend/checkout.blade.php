@extends('frontend.layouts.master')

@section('title', 'Checkout')

@section('content')

    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Checkout</h4>
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li><a href="#">checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->
    <!--============================
        CHECK OUT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__checkout_form">
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="wsus__check_form">
                            <h5>Shipping Details <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal">add
                                    new address</a></h5>
                            <div class="row">
                                @foreach ($addresses as $address)
                                    <div class="col-xl-6">
                                        <div class="wsus__checkout_single_address">
                                            <div class="form-check">
                                                <input class="form-check-input shipping-address" type="radio" name="flexRadioDefault"
                                                    id="address_{{$address->id}}" value="{{$address->id}}">
                                                <label class="form-check-label" for="address_{{$address->id}}">
                                                    Select Address
                                                </label>
                                            </div>
                                            <ul>
                                                <li><span>Name :</span> {{$address->name}}</li>
                                                <li><span>Phone :</span> {{$address->phone}}</li>
                                                <li><span>Email :</span> {{$address->email}}</li>
                                                <li><span>Country :</span> {{$address->country}}</li>
                                                <li><span>State :</span> {{$address->state}}</li>
                                                <li><span>City :</span> {{$address->city}}</li>
                                                <li><span>Zip Code :</span> {{$address->zip_code}}</li>
                                                <li><span>Address :</span> {{$address->address}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="wsus__order_details" id="sticky_sidebar">
                            <p class="wsus__product">shipping Methods</p>
                            @foreach ($shipping_method as $method)
                                @if ($method->type == 'min_cost')
                                    @if (Cart::subtotalFloat() >= $method->min_cost)
                                        <div class="form-check">
                                            <input class="form-check-input shipping-method" type="radio" name="exampleRadios" id="#{{$method->id}}"
                                                value="{{$method->id}}" data-value="{{$method->cost}}">
                                            <label class="form-check-label" for="#{{$method->id}}">
                                                {{$method->name}}
                                                <span>cost: {{$settings->currency_icon}}{{$method->cost}}</span>
                                            </label>
                                        </div>
                                        
                                    @endif
                                @else
                                <div class="form-check">
                                    <input class="form-check-input shipping-method" type="radio" name="exampleRadios" id="#{{$method->id}}"
                                        value="{{$method->id}}" data-value="{{$method->cost}}">
                                    <label class="form-check-label" for="#{{$method->id}}">
                                        {{$method->name}}
                                        <span>cost: {{$settings->currency_icon}}{{$method->cost}}</span>
                                    </label>
                                </div>
                                @endif
                                
                            @endforeach
                            <div class="wsus__order_details_summery">
                                <p>subtotal: <span>{{$settings->currency_icon}}{{Cart::priceTotal()}}</span></p>
                                <p>shipping method(+): <span id="shipping_fee">{{$settings->currency_icon}}0.00</span></p>
                                <p>coupon(-): <span>{{$settings->currency_icon}}{{Cart::discount()}}</span></p>
                                <p><b>total:</b> <span id="total_amount" data-value="{{Cart::subtotalFloat()}}"><b>{{$settings->currency_icon}}
                                    {{Cart::subtotal()}}</b></span></p>
                            </div>
                            <div class="terms_area">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="terms"
                                        checked>
                                    <label class="form-check-label" for="terms">
                                        I have read and agree to the website <a href="#">terms and conditions *</a>
                                    </label>
                                </div>
                            </div>
                            <form id="checkout_form">
                                <input type="hidden" name="shipping_method" id="shipping_method" value="">
                                <input type="hidden" name="shipping_address_id" id="shipping_address_id" value="">
                            </form>
                            <a href="payment.html" id="submitCheckoutForm" class="common_btn">Place Order</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="wsus__popup_address">
        <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">add new address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="wsus__check_form p-3">
                            <form action="{{route('user.address.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="name" value="{{old('name', auth()->user()->name)}}" placeholder="Name">
                                        </div>
                                        @error('name')
                                        <code>{{$message}}</code>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="email" name="email" value="{{old('email', auth()->user()->email)}}" placeholder="Email">
                                        </div>
                                        @error('email')
                                        <code>{{$message}}</code>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text"  name="phone" value="{{old('phone')}}" placeholder="Phone *">
                                        </div>
                                        @error('phone')
                                        <code>{{$message}}</code>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <select class="select_2" name="country">
                                                @foreach (config('settings.countries') as $key => $country)
                                                    <option id="{{$key}}" value="{{$country}}" @selected(old('country') == $country)>{{$country}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('country')
                                        <code>{{$message}}</code>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="state" value="{{old('state')}}" placeholder="State *">
                                        </div>
                                        @error('state')
                                        <code>{{$message}}</code>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="city" value="{{old('city')}}" placeholder="Town / City *">
                                        </div>
                                        @error('city')
                                        <code>{{$message}}</code>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="address" value="{{old('address')}}" placeholder="Street Address *">
                                        </div>
                                        @error('address')
                                        <code>{{$message}}</code>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="zip_code" value="{{old('zip_code')}}" placeholder="Zip Code *">
                                        </div>
                                        @error('zip_code')
                                        <code>{{$message}}</code>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============================
        CHECK OUT PAGE END
    ==============================-->
@endsection

@push('scripts')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        //change shipping method
        $('.shipping-method').on('click', function(){
            $('#shipping_method').val($(this).val())
            $('#shipping_fee').html(`{{$settings->currency_icon}}${parseFloat($(this).data('value'))
                .toLocaleString("en-US", {style: 'decimal',minimumFractionDigits: 2, maximumFractionDigits: 2,})}`)
            let total = $('#total_amount').data('value')  + $(this).data('value')
            $('#total_amount').html(`{{$settings->currency_icon}}${parseFloat(total)
            .toLocaleString("en-US", {style: 'decimal',minimumFractionDigits: 2, maximumFractionDigits: 2,})}`)
        })

        //change shipping address
        $('.shipping-address').on('click', function(){
            $('#shipping_address_id').val($(this).val())
        })

        //submit checkout form
        $('#submitCheckoutForm').on('click', function(e){
            e.preventDefault()
            if($('#shipping_method').val() === ""){
                toastr.error('Choose a shipping method!')
            }else if($('#shipping_address_id').val() === ""){
                toastr.error('Choose a shipping address!')
            }else if(!$('#terms').prop('checked')){
                toastr.error('You have to agree to the terms and conditions!')
            }else{
                $.ajax({
                    url: "{{route('checkout')}}",
                    method: "POST",
                    data: $('#checkout_form').serialize(),
                    beforeSend: function(){
                        $('#submitCheckoutForm').html('<i class="fas fa-spinner fa-spin"></i>')
                    },
                    success: function(data){
                        if(data.status == "success"){
                            $('#submitCheckoutForm').html('Place Order')
                            window.location.href = data.redirect_url
                        }
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })
    })
    @if($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{$error}}')
        @endforeach
    @endif
  </script>
@endpush