<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        (function(global){
            //get cart products
            function getCartProducts(){
                $.ajax({
                    method: 'get',
                    url: '{{route('cart-products')}}',
                    success: function(data){
                        $('.mini_cart_wrapper').html('')
                        let html = ``
                        let currency = "{{$settings->currency_icon}}"
                        let image_url = '{{asset('product/')}}'
                        for (let item in data) {
                            let cartItem = data[item]
                            let variant = cartItem.options.variants
                            let variant_html = ``
                            for ( key in cartItem.options.variants) {
                                variant_html += `<b>${key}</b>: ${variant[key]['name']} `
                            }
                           
                            html += `  <li id="mini_cart_${cartItem.rowId}">
                                <div class="wsus__cart_img">
                                    <a href="#"><img src="${image_url+'/'+ cartItem.options.thumb_img}" alt="product" class="img-fluid w-100"></a>
                                    <a class="wsis__del_icon delete-cart-item" href="#" data-row-id="${cartItem.rowId}"><i class="fas fa-minus-circle"></i></a>
                                </div>
                                <div class="wsus__cart_text">
                                    <a class="wsus__cart_title" href="{{url('product/')}}${'/'+cartItem.options.slug}">${cartItem.name}</a>
                                    <p>${currency+parseFloat(cartItem.price).toLocaleString("en-US", {style: 'decimal',minimumFractionDigits: 2, maximumFractionDigits: 2,})}</p>
                                    <small><b>Qty</b>: ${cartItem.qty}</small><br>
                                    <small> ${variant_html}</small>
                                </div>
                            </li>`                                
                        }
                        $('.mini_cart_wrapper').html(html)
                    },
                    error: function(data){
                        console.log(data)
    
                    }
                }) 
            }
             //get cart subtotal
            function getCartSubtotal(){
                $.ajax({
                    method: 'get',
                    url: '{{route('cart-subtotal')}}',
                    success: function(data){
                        $('#mini_cart_subtotal').html(`{{$settings->currency_icon}}`+data)
                        let subtotal = document.querySelector('#cart_subtotal')
                        if(subtotal){
                            $('#cart_subtotal').html(`{{$settings->currency_icon}}`+data)
                        }
    
                    },
                    error: function(data){
                        console.log(data)
    
                    }
                }) 
            }

            global.bundleObj = {
                getCartProducts: getCartProducts,
                getCartSubtotal: getCartSubtotal
            }
        })(window)
        
        //get cart count
        function getCartCount(){
            $.ajax({
                method: 'get',
                url: '{{route('cart-count')}}',
                success: function(data){
                    $('#cart_count').html(data)
                },
                error: function(data){
                    console.log(data)

                }
            }) 
        }

        $('.shopping-cart-form').on('submit', function(e){
            e.preventDefault()
            let formData = $(this).serialize()
            $.ajax({
                method: 'POST',
                data: formData,
                url: '{{route('add-to-cart')}}',
                success: function(data){
                    if(data['status'] == 'success'){
                        getCartCount()
                        window.bundleObj.getCartSubtotal()
                        window.bundleObj.getCartProducts()
                        $('.mini_cart_actions').removeClass('d-none')
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

        $('body').on('click', '.delete-cart-item', function(e){
            e.preventDefault()
            let id = $(this).data('row-id')

            $.ajax({
                    method: 'POST',
                    url: '{{route('delete-cart-item')}}',
                    data: {
                        id : id
                    },
                    success: function(data){
                        let product_id = '#mini_cart_'+id
                        $(product_id).remove()
                        getCartSubtotal()
                        getCartCount()
                        if($('.mini_cart_wrapper').find('li').length === 0){
                            $('.mini_cart_actions').addClass('d-none')
                            $('.mini_cart_wrapper').html('<li class="text-center">Cart is Empty!</li>')
                        }
                    },
                    error: function(data){
                        console.log(data)

                    }
                }) 
        })

        //product modal
        $('.quickview').each(function(){
           $(this).on('click', function(){
               let value = $(this).attr('id')
               let currency = '{{$settings->currency_icon}}'
               let image_url = '{{asset('product/')}}'
               $.get('/get-product/'+value, function (data){
                   data = JSON.parse(data)
                   $('#modal_product_id').val(data['id'])
                   $('#modal_product').html(data['name'])
                   $('#modal_desc').html(data['short_desc'])
                   $('#modal_sku').html('sku: '+data['sku'])
                   $('#modal_brand').html('brand: '+data['brand']['name'])
                   //price
                   let price = ``
                   const start = Date.parse(data['offer_start']);
                   const end = Date.parse(data['offer_end']);
                   const d = Date.now();
                   
                   if(d >= start && d <= end){
                       $('#modal_price').html(` ${currency+data['offer_price']}<del>${currency+data['price']}</del>`)
                   } 
                   else{
                       $('#modal_price').html(` ${currency+data['price']}`)
                   }
                   //stock
                   if(data['quantity'] > 0){
                       $('#modal_stock').html(`<span class="in_stock">in stock</span> (${data['quantity']} items)`)
                   }
                   else{
                       $('#modal_stock').html(`<span class="out_stock">out of stock</span> (${data['quantity']} items)`)
                   }
                   //video
                   if(data['video_link']){
                       $('#modal_video').attr('href', data['video_link'])
                       $('#modal_video').removeClass('d-none')

                   }
                   else{
                       $('#modal_video').addClass('d-none')
                       $('#modal_video').attr('href', '#')

                   }
                   //images
                   $('.modal_slider').slick('removeSlide', null, null, true);
                   if(data['images'].length == 1){
                       $('.modal_slider').slick('slickAdd', `<div class="col-xl-12">
                               <div class="modal_slider_img">
                                   <img src="${image_url+'/'+data['images'][0]['image']}" alt="product" class="img-fluid w-100">
                               </div>
                           </div>`);
                           $('.modal_slider').slick('slickAdd', `<div class="col-xl-12">
                               <div class="modal_slider_img">
                                   <img src="${image_url+'/'+data['thumb_img']}" alt="product" class="img-fluid w-100">
                               </div>
                           </div>`);
                   }
                   else {
                       data['images'].forEach(element => {
                           $('.modal_slider').slick('slickAdd', `<div class="col-xl-12">
                                   <div class="modal_slider_img">
                                       <img src="${image_url+'/'+element['image']}" alt="product" class="img-fluid w-100">
                                   </div>
                               </div>`);
                       });
                   }
                   //variants
                   let variant_select = ``
                   let variants = data['active_variants']
                   variants.forEach(variant => {
                       variant_select += ` <div class="col-xl-6 col-sm-6 mb-2">
                           <h5 class="mb-2">${variant['name']}:</h5>
                           <select class="modal_variant" name="variants[]">`
                       variant['active_items'].forEach(item => {
                           variant_select += `<option value="${item['id']}">${item['name']} (${currency}${item['price']})</option>`
                       })
                       variant_select += `</select>
                       </div>`
                   });
                   $('#modal_variant').html(variant_select)
                   $('.modal_variant').select2()
                   $('#exampleModal').modal('show')
                   
                          
               })
           })
        })

       
    })
</script>