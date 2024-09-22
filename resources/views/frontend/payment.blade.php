@extends('frontend.layouts.master')

@section('title', 'Payment')

@section('content')

    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Payment</h4>
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li><a href="#">payment</a></li>
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
        PAYMENT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__pay_info_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="wsus__payment_menu" id="sticky_sidebar">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link common_btn active" id="v-pills-flutterwave-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-flutterwave" type="button" role="tab" aria-controls="v-pills-home"
                                    aria-selected="true">flutterwave</button>
                                <button class="nav-link common_btn" id="v-pills-paystack-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-paystack" type="button" role="tab" aria-controls="v-pills-home"
                                    aria-selected="true">paystack (₦)</button>
                                <button class="nav-link common_btn" id="v-pills-settings-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-settings" type="button" role="tab"
                                    aria-controls="v-pills-settings" aria-selected="false">cash on delivery</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="tab-content" id="v-pills-tabContent" id="sticky_sidebar">
                            <div class="tab-pane fade show active" id="v-pills-flutterwave" role="tabpanel"
                                aria-labelledby="v-pills-flutterwave-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <form method="post" action="{{route('flutterwave-pay')}}">
                                                @csrf
                                                <div class="wsus__pay_caed_header">
                                                    <h5>Input details</h5>
                                                    <img src="{{asset('frontend/images/flutterwave.svg')}}" alt="payment" class="img-fluid">
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input class="input" name="name" type="text" value="{{old('name', auth()->user()->name)}}" placeholder="Name">
                                                            @error('name')
                                                            <code>{{$message}}</code>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <input class="input" name="email" type="email" value="{{old('email', auth()->user()->email)}}" placeholder="Email">
                                                            @error('email')
                                                            <code>{{$message}}</code>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <input class="input" name="phone" type="text" value="{{old('phone')}}" placeholder="Phone Number">
                                                        @error('phone')
                                                        <code>{{$message}}</code>
                                                    @enderror
                                                    </div>
                                                </div>
                                                <button type="submit" class="common_btn">Pay Now</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-paystack" role="tabpanel"
                                aria-labelledby="v-pills-paystack-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <form method="post" action="{{route('paystack-pay')}}">
                                                @csrf
                                                <div class="wsus__pay_caed_header">
                                                    <h5>Input details</h5>
                                                    <img src="{{asset('frontend/images/paystack.svg')}}"  alt="payment" class="img-fluid">
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input class="input" name="paystack_email" type="email" value="{{old('paystack_email', auth()->user()->email)}}"placeholder="Email">
                                                            @error('paystack_email')
                                                                <code>{{$message}}</code>
                                                            @enderror
                                                    </div>
                                                </div>
                                                <button type="submit" class="common_btn">Pay Now</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                aria-labelledby="v-pills-settings-tab">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero, tempora cum optio
                                    cumque rerum dolor impedit exercitationem? Eveniet suscipit repellat, quae natus hic
                                    assumenda consequatur excepturi ducimus.</p>
                                <ul>
                                    <li>Natus hic assumenda consequatur excepturi ducimu.</li>
                                    <li>Cumque rerum dolor impedit exercitationem Eveniet suscipit repellat.</li>
                                    <li>Dolor sit amet consectetur adipisicing elit tempora cum .</li>
                                    <li>Orem ipsum dolor sit amet consectetur adipisicing elit asperiores.</li>
                                </ul>
                                <form class="wsus__input_area">
                                    <input type="text" placeholder="Enter Something">
                                    <textarea cols="3" rows="4" placeholder="Enter Something"></textarea>
                                    <select class="select_2" name="state">
                                        <option>default select</option>
                                        <option>short by rating</option>
                                        <option>short by latest</option>
                                        <option>low to high </option>
                                        <option>high to low</option>
                                    </select>
                                    <button type="submit" class="common_btn mt-4">confirm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="wsus__pay_booking_summary" id="sticky_sidebar2">
                            <h5>Summary</h5>
                            <p>subtotal: <span>{{$settings->currency_icon}}{{Cart::priceTotal()}}</span></p>
                            <p>shipping fee (+): <span>{{$settings->currency_icon}}{{number_format(getShippingFee(),2)}}</span></p>
                            <p>coupon(-): <span>{{$settings->currency_icon}}{{Cart::discount()}}</span></p>
                            <h6>total <span>{{$settings->currency_icon}}{{number_format(Cart::subtotalFloat() + getShippingFee(),2)}}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PAYMENT PAGE END
    ==============================-->
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        @if($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{$error}}')
            @endforeach
        @endif
    })
</script>
  
@endpush

