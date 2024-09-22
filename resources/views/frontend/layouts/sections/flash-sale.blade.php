   @if (\Carbon\Carbon::today()->lt($flashSale->end_date))
        <section id="wsus__flash_sell" class="wsus__flash_sell_2">
            <div class=" container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="offer_time" style="background: url({{asset('frontend/images/flash_sell_bg.jpg')}})">
                            <div class="wsus__flash_coundown">
                                <span class=" end_text">flash sale</span>
                                <div class="simply-countdown simply-countdown-one"></div>
                                <a class="common_btn" href="{{route('flash-sale')}}">see more <i class="fas fa-caret-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row flash_sell_slider">
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

                </div>
            </div>
        </section> 
    @endif

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
    