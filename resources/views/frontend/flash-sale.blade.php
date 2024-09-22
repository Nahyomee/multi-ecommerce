@extends('frontend.layouts.master')

@section('title', 'Flash Sale')

@section('content')

    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Flash Sale</h4>
                        <ul>
                            <li><a href="{{route('index')}}">Home</a></li>
                            <li><a href="#">Flash Sale</a></li>
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
        DAILY DEALS DETAILS START
    ==============================-->
    <section id="wsus__daily_deals">
        <div class="container">
            <div class="wsus__offer_details_area">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{asset('frontend/images/offer_banner_2.png')}}" alt="offer img" class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>apple watch</p>
                                <span>up 50% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{asset('frontend/images/offer_banner_3.png')}}" alt="offer img" class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>xiaomi power bank</p>
                                <span>up 37% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                </div>

            @if (\Carbon\Carbon::today()->lt($flashSale->end_date))
                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__section_header rounded-0">
                            <h3>flash sell</h3>
                            <div class="wsus__offer_countdown">
                                <span class="end_text">ends time :</span>
                                <div class="simply-countdown simply-countdown-one"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($flashSaleItems as $item)
                    @php
                        $product = $item->product;
                    @endphp
                         <div class="col-xl-3 col-sm-6 col-lg-4">
                            <div class="wsus__product_item">
                                <span class="wsus__new">{{$product->type}}</span>
                                @if($product->hasDiscount)
                                <span class="wsus__minus">-{{$product->discount_percentage}}%</span>
                                @endif
                                <a class="wsus__pro_link" href="{{route('product', ['product' => $product])}}">
                                    <img src="{{asset('product/'.$product->thumb_img)}}" alt="product" class="img-fluid w-100 img_1" />
                                    <img src="{{asset('product/'.$product->images()?->first()?->image)}}" alt="product" class="img-fluid w-100 img_2" />
                                </a>
                                <ul class="wsus__single_pro_icon">
                                    <li><a href="#" class="quickview" id="{{$product->id}}"><i class="far fa-eye"></i></a></li>
                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                    <li><a href="#"><i class="far fa-random"></i></a>
                                </ul>
                                <div class="wsus__product_details">
                                    <a class="wsus__category" href="#">{{$product->category->name}} </a>
                                    <p class="wsus__pro_rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(133 review)</span>
                                    </p>
                                    <a class="wsus__pro_name" href="{{route('product', ['product' => $product])}}">{{$product->name}}</a>
                                    @if($product->hasDiscount)
                                    <p class="wsus__price">{{$settings->currency_icon}}{{$product->offer_price}} <del>{{$settings->currency_icon}}{{$product->price}}</del></p>
                                    @else
                                    <p class="wsus__price">{{$settings->currency_icon}}{{$product->price}} </p>
    
                                    @endif
                                    <form class="shopping-cart-form">
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        @foreach ($product->variants()->active()->get() as $variant)
                                            <select class="d-none" name="variants[]">
                                                @foreach ($variant->items()->active()->orderByDesc('is_default')->get() as $item )
                                                <option value="{{$item->id}}">{{$item->name}} ({{$settings->currency_icon}}{{$item->price}})</option>
                                                @endforeach
                                            </select>                                    
                                        @endforeach 
                                        <input name="quantity" type="hidden" value="1" />
                                        <button type="submit" class="add_cart">add to cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach
                    {{$flashSaleItems->links('vendor.pagination.frontend')}}
                </div>
            @else
                <div class="row text-center">
                    <div class="col-md-12">
                        <div class="wsus__cart_list cart_empty p-3 p-sm-5 text-center">
                            <h3>No item available now!</h3>
                                <a href="{{route('products')}}" class="common_btn">
                                    <i class="fal fa-store me-2"></i>view our available products</a>

                        </div>

                    </div>
                </div>
            @endif
            </div>
        </div>
    </section>
    <!--============================
        DAILY DEALS DETAILS END
    ==============================-->

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        var dt = new Date("{{$flashSale->end_date}}")
        simplyCountdown('.simply-countdown-one', {
           year: dt.getFullYear(),
           month: dt.getMonth() + 1,
           day: dt.getDate(),
       });

    })
</script>
@endpush