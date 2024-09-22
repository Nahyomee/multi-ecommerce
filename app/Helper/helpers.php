<?php

use Illuminate\Support\Facades\Session;

/** Set sidebar to active */

function setActive(array $route)
{
    if(is_array($route)){
        foreach($route as $r){
            if(request()->routeIs($r)){
                return 'active';
            }
        }
    }
}

/** Get first character of each word in a string */

function getInitials($string)
{
    $words = explode(' ', strtoupper($string));
    $initial = '';
    
    foreach ($words as $w) {
        $initial .= $w[0];
    } 
    return $initial;
}

/** Get shipping fee */

function getShippingFee()
{
    if(Session::has('shipping_method')){
        return Session::get('shipping_method')['cost'];
    }
    else{
        return 0;
    }
}

/** Check if user has used max coupon */

function checkUserCouponUse($id)
{
    $user_coupons = auth()->user()->orders()->pluck('coupon')->toArray();
    $coupons_arr = array_map(function($coupon){
        return json_decode($coupon);
    }, $user_coupons);
    $coupons = array_filter($coupons_arr, function($coupon) use($id){
        return $coupon->coupon_id == $id;
    });
    return count($coupons);
}
