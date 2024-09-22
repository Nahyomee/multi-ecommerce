@extends('frontend.layouts.master')

@section('title', 'Index')

@section('content')
    

    <!--============================
        BANNER PART 2 START
    ==============================-->
    @include('frontend.layouts.sections.slider')
    <!--============================
        BANNER PART 2 END
    ==============================-->


    <!--============================
        FLASH SELL START
    ==============================-->
    @include('frontend.layouts.sections.flash-sale')
    <!--============================
        FLASH SELL END
    ==============================-->


    <!--============================
       MONTHLY TOP PRODUCT START
    ==============================-->
    @include('frontend.layouts.sections.top-products')
    <!--============================
       MONTHLY TOP PRODUCT END
    ==============================-->


    <!--============================
        BRAND SLIDER START
    ==============================-->
    @include('frontend.layouts.sections.brand-slider')
    <!--============================
        BRAND SLIDER END
    ==============================-->


    <!--============================
        SINGLE BANNER START
    ==============================-->
    @include('frontend.layouts.sections.single-banner')
    <!--============================
        SINGLE BANNER END  
    ==============================-->


    <!--============================
        HOT DEALS START
    ==============================-->
    @include('frontend.layouts.sections.hot-deals')
    <!--============================
        HOT DEALS END  
    ==============================-->


     <!--============================
        CATEGORY SLIDER START 
    ==============================-->
    @include('frontend.layouts.sections.category-product-slider')

     <!--============================
        CATEGORY SLIDER END  
    ==============================-->


    <!--============================
        LARGE BANNER  START  
    ==============================-->
    @include('frontend.layouts.sections.large-banner')
    <!--============================
        LARGE BANNER  END  
    ==============================-->


    <!--============================
        WEEKLY BEST ITEM START  
    ==============================-->
    @include('frontend.layouts.sections.weekly-best-item')
    <!--============================
        WEEKLY BEST ITEM END 
    ==============================-->


    <!--============================
      HOME SERVICES START
    ==============================-->
    @include('frontend.layouts.sections.services')
    <!--============================
        HOME SERVICES END
    ==============================-->


    <!--============================
        HOME BLOGS START
    ==============================-->
    @include('frontend.layouts.sections.blog')
    <!--============================
        HOME BLOGS END
    ==============================-->

@endsection