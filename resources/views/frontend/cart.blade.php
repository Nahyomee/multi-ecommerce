@extends('frontend.layouts.master')

@section('title', 'Cart')

@section('content')

    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Cart</h4>
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li><a href="#">cart</a></li>
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
        CART VIEW PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            @if (count($cartItems) > 0)
                <div class="row">
                    <div class="col-xl-9">
                        <div class="wsus__cart_list">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr class="d-flex">
                                            <th class="wsus__pro_img">
                                                product item
                                            </th>
    
                                            <th class="wsus__pro_name">
                                                product details
                                            </th>
    
                                            <th class="wsus__pro_status">
                                                status
                                            </th>
    
                                            <th class="wsus__pro_select">
                                                quantity
                                            </th>
    
                                            <th class="wsus__pro_tk">
                                                price
                                            </th>

                                            <th class="wsus__pro_tk">
                                                total price
                                            </th>
    
                                            <th class="wsus__pro_icon">
                                                <a href="#" class="common_btn clear-cart">clear cart</a>
                                            </th>
                                        </tr>
                                        @foreach ($cartItems as $item)
                                            <tr class="d-flex">
                                                <td class="wsus__pro_img"><img src="{{asset('product/'.$item->options->thumb_img)}}" alt="product"
                                                        class="img-fluid w-100">
                                                </td>
        
                                                <td class="wsus__pro_name">
                                                    <p>{{$item->name}}</p>
                                                    @foreach ($item->options->variants as $key => $variant)
                                                        <span>{{$key}}: {{$variant['name']}}({{$settings->currency_icon}}{{$variant['price']}})</span>
                                                    @endforeach
                                                </td>
        
                                                <td class="wsus__pro_status">
                                                    @if (App\Models\Product::find($item->id)->quantity < $item->qty)
                                                    <span>out of stock</span>
                                                    @else
                                                    <p>in stock</p>
                                                    @endif
                                                </td>
        
                                                <td class="wsus__pro_select">
                                                    <div class="product_qty_wrapper">
                                                        <button  class="btn btn-danger product-decrement @if($item->qty == 1)disabled @endif">-</button>
                                                        <input readonly class="product_qty" data-row-id="{{$item->rowId}}" type="text" min="1" max="100" value="{{$item->qty}}" />
                                                        <button  class="btn btn-success product-increment">+</button>
                                                    </div>
                                                </td>

                                                <td class="wsus__pro_tk">
                                                    <h6>{{$settings->currency_icon}}{{number_format($item->price,2)}}</h6>
                                                </td>
        
                                                <td class="wsus__pro_tk">
                                                    <h6 id="{{$item->rowId}}">{{$settings->currency_icon}}{{number_format($item->price * $item->qty,2)}}</h6>
                                                </td>
        
                                                <td class="wsus__pro_icon">
                                                    <a href="{{route('delete-from-cart', ['id' => $item->rowId])}}"><i class="far fa-times"></i></a>
                                                </td>
                                            </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                            <h6>total cart</h6>
                            <p>subtotal: <span id="cart_subtotal">{{$settings->currency_icon}}{{Cart::priceTotal(2)}}</span></p>
                            <p>coupon(-):<span id="cart_discount">{{$settings->currency_icon}}{{Cart::discount(2)}} <small class="fw-bold remove-coupon-span {{session()->has('coupon') ? '' : 'd-none'}}"><a class="text-danger"  id="remove-coupon">x</a></small>
                                </span></p>
                            <p class="total"><span>total:</span> <span id="cart_total">{{$settings->currency_icon}}{{Cart::total(2)}}</span></p>

                            <form id="coupon_form">
                                <input type="text" id="coupon_code" value="{{Session::has('coupon') ? Session::get('coupon')['coupon_code'] : ''}}" name="coupon" placeholder="Coupon Code">
                                <button type="submit" class="common_btn">apply</button>
                            </form>
                            <a class="common_btn mt-4 w-100 text-center" href="{{route('checkout-page')}}">checkout</a>
                            <a class="common_btn mt-1 w-100 text-center" href="{{route('products')}}"><i
                                    class="fab fa-shopify"></i> go shop</a>
                        </div>
                    </div>
                </div>
            @else
            <div class="col-xl-12">
                <div class="wsus__cart_list cart_empty p-3 p-sm-5 text-center">
                    <p class="mb-4">your shopping cart is empty</p>
                    <a href="{{route('products')}}" class="common_btn"><i class="fal fa-store me-2"></i>view our
                        products</a>
                </div>
            </div>   
            @endif
        </div>
    </section>
    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content">
                        <div class="wsus__single_banner_img">
                            <img src="images/single_banner_2.jpg" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>sell on <span>35% off</span></h6>
                            <h3>smart watch</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_img">
                            <img src="images/single_banner_3.jpg" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>New Collection</h6>
                            <h3>Cosmetics</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
          CART VIEW PAGE END
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

        function calculateCouponDiscount(){
            $.ajax({
                method: 'GET',
                url: '{{route('coupon-calculation')}}',
                success: function(data){
                    if(data['status'] == 'success'){
                        $('#cart_discount').html(`{{$settings->currency_icon}}${parseFloat(data['discount'])
                        .toLocaleString("en-US", {style: 'decimal',minimumFractionDigits: 2, maximumFractionDigits: 2,})}
                        <span class="fw-bold remove-coupon-span"><a class="text-danger" id="remove-coupon">x</a></span>`)
                        $('#cart_total').html(`{{$settings->currency_icon}}${parseFloat(data['cart_total'])
                        .toLocaleString("en-US", {style: 'decimal',minimumFractionDigits: 2, maximumFractionDigits: 2,})}`)
                        if(data['discount'] === 0){
                            $('.remove-coupon-span').hide()
                            $('#coupon_code').val('')
                        }else{
                            $('.remove-coupon-span').show()
                        }
                    }
                    else{
                        $('#cart_discount').html(`{{$settings->currency_icon}}${parseFloat(data['discount'])
                        .toLocaleString("en-US", {style: 'decimal',minimumFractionDigits: 2, maximumFractionDigits: 2,})}
                        <span class="fw-bold remove-coupon-span"><a class="text-danger" id="remove-coupon">x</a></span>`)
                        $('#cart_total').html(`{{$settings->currency_icon}}${parseFloat(data['cart_total'])
                        .toLocaleString("en-US", {style: 'decimal',minimumFractionDigits: 2, maximumFractionDigits: 2,})}`)
                        if(data['discount'] === 0){
                            $('.remove-coupon-span').hide()
                            $('#coupon_code').val('')
                        }else{
                            $('.remove-coupon-span').show()
                        }
                        toastr.error(data['message'])
                    }

                },
                error: function(xhr, status, error){
                    toastr.error(error)

                }
            }) 
        }


        //product decrement
        $('.product-decrement').on('click',function(){
            let input = $(this).siblings('.product_qty')
            let quantity = parseInt(input.val()) - 1
            let id = input.attr('data-row-id')
            input.val(quantity)
            if(quantity == 1){
                $(this).addClass('disabled')
            }
            $.ajax({
                url: '{{route('update-cart')}}',
                method: 'POST',
                data: {
                    quantity: quantity,
                    id: id
                },
                success: function(data){
                    if(data['status'] === 'success'){
                        let product = '#'+id
                        $(product).text('{{$settings->currency_icon}}'+(parseFloat(data['total_price']).toLocaleString("en-US", {style: 'decimal',  // Other options: 'currency', 'percent', etc.
                            minimumFractionDigits: 2, maximumFractionDigits: 2,})))
                        window.bundleObj.getCartSubtotal()
                        window.bundleObj.getCartProducts()
                        calculateCouponDiscount()

                        toastr.success(data['message'])
                    }
                    else{
                        toastr.error(data['message'])
                    }

                },
                error: function(xhr, status, error){
                    toastr.error(error)

                }
            })
        })

        //product increment
        $('.product-increment').on('click',function(){
            let input = $(this).siblings('.product_qty')
            let quantity = parseInt(input.val()) + 1
            let id = input.attr('data-row-id')
            input.val(quantity)
            $(this).siblings('.product-decrement').removeClass('disabled')

            $.ajax({
                url: '{{route('update-cart')}}',
                method: 'POST',
                data: {
                    quantity: quantity,
                    id: id
                },
                success: function(data){
                    if(data['status'] === 'success'){
                        let product = '#'+id
                        $(product).text('{{$settings->currency_icon}}'+(parseFloat(data['total_price']).toLocaleString("en-US", {style: 'decimal',minimumFractionDigits: 2, maximumFractionDigits: 2,})))
                        window.bundleObj.getCartSubtotal()
                        window.bundleObj.getCartProducts()
                        calculateCouponDiscount()
                        toastr.success(data['message'])
                    }
                    else{
                        input.val(quantity - 1)
                        toastr.error(data['message'])
                    }

                },
                error: function(xhr, status, error){
                    toastr.error(error)

                }
            })


        })

        //clear cart
        $('.clear-cart').on('click', function(e){
            e.preventDefault()
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "This action will clear your cart!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, clear it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: 'POST',
                    url: '{{route('clear-cart')}}',

                    success: function(data){

                    if(data.status == 'success'){
                        swalWithBootstrapButtons.fire(
                        'Deleted!',
                        data.message,
                        'success'
                        )
                        window.location.reload()
                    }
                    if(data.status == 'error'){
                        swalWithBootstrapButtons.fire(
                        'Oops!',
                        data.message,
                        'error'
                        )
                    }
                    },
                    error: function(xhr, status, error) {
                    swalWithBootstrapButtons.fire(
                        'Oops!',
                        'Error clearing cart!',
                        'error'
                    )
                    }
                })
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your data is safe :)',
                'error'
                )
            }
            })
        })

        //apply coupon
        $('#coupon_form').on('submit', function(e){
            e.preventDefault()
            let formData = $(this).serialize()
            $.ajax({
                method: 'POST',
                data: formData,
                url: '{{route('apply-coupon')}}',
                success: function(data){
                    if(data['status'] == 'success'){
                        calculateCouponDiscount()
                        toastr.success(data['message'])
                    }
                    else{
                        toastr.error(data['message'])
                    }

                },
                error: function(xhr, status, error){
                    toastr.error(error)

                }
            }) 

            
        })

        //remove coupon
        $('body').on('click', '#remove-coupon',function(){
            $.ajax({
                url: '{{route('remove-coupon')}}',
                method: 'GET',
                success: function(data){
                    if(data['status'] === 'success'){
                        calculateCouponDiscount()
                        toastr.success(data['message'])
                    }
                    else{
                        toastr.error(data['message'])
                    }

                },
                error: function(xhr, status, error){
                    toastr.error(error)

                }
            })


        })
        
    })
</script>
  
@endpush

