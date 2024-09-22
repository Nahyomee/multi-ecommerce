<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /** View cart page */
    public function cart()
    {
        $cartItems = Cart::content();
        return view('frontend.cart', compact('cartItems'));
    }

    /** Add to cart */
    public function addToCart(Request $request)
    {
        $product  = Product::findOrFail($request->product_id);
        if($product->quantity == 0 ){
            return response(['status' => 'error', 'message' => 'Product is out of stock!']);
        }
        if($product->quantity < $request->quantity){
            return response(['status' => 'error', 'message' => 'Quantity not available in stock!']);
        }
        $variants = [];
        $variantTotal = 0;
        if($request->has('variants')){
            foreach($request->variants as $item){
                $variantItem = ProductVariantItem::findOrFail($item);
                $variants[$variantItem->variant->name]['name'] = $variantItem->name;
                $variants[$variantItem->variant->name]['price'] = $variantItem->price;
                $variantTotal += $variantItem->price;
            }
        }
        $totalPrice = $variantTotal + $product->discount;
        $options['variants'] = $variants;
        $options['thumb_img'] = $product->thumb_img;
        $options['slug'] = $product->slug;
        $item = [];
        $item['id'] = $product->id;
        $item['name'] = $product->name;
        $item['qty'] = $request->quantity;
        $item['price'] = $totalPrice;
        $item['weight'] = 0;
        $item['options'] = $options;

        Cart::add($item);

        return response(['status' => 'success', 'message' => 'Item added to cart']);
    }
    
    /** Update cart */
    public function updateCart(Request $request)
    {
        $product  = Product::findOrFail(Cart::get($request->id)->id);
        if($product->quantity == 0 ){
            return response(['status' => 'error', 'message' => 'Product is out of stock!']);
        }
        if($product->quantity < $request->quantity){
            return response(['status' => 'error', 'message' => 'Quantity not available in stock!']);
        }
        if(Cart::update($request->id, $request->quantity)){
            $total = $this->getProductTotal($request->id);
            return response(['status' => 'success', 'message' => 'Quantity updated!', 'total_price' => $total]);
        }
        return response(['status' => 'error', 'message' => 'Error updating quantity!']);

    }

    /** Clear cart */
    public function clearCart()
    {
        Cart::destroy();
        Session::forget('coupon');
        return response(['status' => 'success', 'message' => 'Cart cleared!',]);
    }

    /** Delete product from cart */
    public function deleteFromCart($id)
    {
        Cart::remove($id);
        if(Cart::content()->count() == 0){
            Session::forget('coupon');
        }
        return back()->with('success',  'Product removed from cart!');
    }

    /** Delete product from cart Ajax */
    public function removeFromCart(Request $request)
    {
        Cart::remove($request->id);
        if(Cart::content()->count() == 0){
            Session::forget('coupon');
        }
        return response(['status' => 'success', 'message' => 'Product removed from cart!']);
    }

    /** Get product total */
    public function getProductTotal($rowId)
    {
        $product = Cart::get($rowId);
        return $product->price * $product->qty;
    }

    /** Get cart count */
    public function cartCount()
    {
        return Cart::content()->count();
    }

    /** Get cart subtotal */
    public function cartSubtotal()
    {
        return Cart::priceTotal(2);
    }


    /** Get cart products */
    public function getCartProducts()
    {
        return Cart::content();
    }

    /** Apply coupon */
    public function applyCoupon(Request $request)
    {
        if($request->coupon === null){
            return response(['status' => 'error', 'message' => 'Coupon field required!']);
        }
        
        $coupon = Coupon::where('status',1)->where('code', $request->coupon)->first();
        if($coupon == null){
            return response(['status' => 'error', 'message' => 'Coupon not found!']);
        }
        elseif($coupon->start_date > date('Y-m-d')){
            return response(['status' => 'error', 'message' => 'Coupon not found!']);
        }
        elseif($coupon->end_date < date('Y-m-d')){
            return response(['status' => 'error', 'message' => 'Coupon expired!']);
        }
        elseif($coupon->total_used >= $coupon->quantity){
            return response(['status' => 'error', 'message' => 'You can\'t apply this coupon!']);
        }
        elseif(checkUserCouponUse($coupon->id) >= $coupon->max_use){
            return response(['status' => 'error', 'message' => 'You\'ve used this coupon for the maximum amount of time!']);
        }
        else{
            if($coupon->discount_type == 'amount'){
                if($coupon->discount_value > Cart::priceTotalFloat()){
                    return response(['status' => 'error', 'message' => 'You can\'t apply this coupon!']);
                }
                Session::put('coupon',[
                    'coupon_id' => $coupon->id,
                    'coupon_name' => $coupon->name,
                    'coupon_code' => $coupon->code,
                    'discount_type' => $coupon->discount_type,
                    'discount' => $coupon->discount_value,
                ]);
            }
            elseif($coupon->discount_type == 'percentage'){
                Session::put('coupon',[
                    'coupon_id' => $coupon->id,
                    'coupon_name' => $coupon->name,
                    'coupon_code' => $coupon->code,
                    'discount_type' => $coupon->discount_type,
                    'discount' => $coupon->discount_value,
                ]);
            }
            return response(['status' => 'success', 'message' => 'Coupon applied succesfully!']);
        }
    }

     /** Remove coupon */
     public function removeCoupon(Request $request)
     {
        Session::forget('coupon');
        Cart::setGlobalDiscount(0);
        return response(['status' => 'success', 'message' => 'Coupon removed succesfully!']);
        
     }

    /**Coupon calculation */
    public function couponCalculation()
    {
        if(Session::has('coupon')){
            $coupon = Session::get('coupon');
            $subtotal = Cart::priceTotalFloat();
            if($coupon['discount_type'] == 'amount'){
                //if the discount is more than the amount
                if($coupon['discount'] > $subtotal){
                    Session::forget('coupon');
                    Cart::setGlobalDiscount(0);
                    return response(['status' => 'error', 'message' => 'You can\'t apply this coupon!', 'cart_total' => $subtotal, 'discount' => 0]);
                }
                $total = $subtotal - $coupon['discount'];
                //get discount in percent
                $percent = ($coupon['discount'] * 100)/$subtotal;
                Cart::setGlobalDiscount($percent);
                return response(['status' => 'success', 'cart_total' => $total, 'discount' => $coupon['discount']]);
            }
            elseif($coupon['discount_type'] == 'percentage'){
                $discount = $coupon['discount'] * $subtotal / 100;
                $total = $subtotal - $discount;
                Cart::setGlobalDiscount($coupon['discount']);
                return response(['status' => 'success', 'cart_total' => $total, 'discount' => $discount]);
            }
        }
        else{
            $total = Cart::priceTotalFloat();
            return response(['status' => 'success', 'cart_total' => $total, 'discount' => 0]);

        }
    }

}
