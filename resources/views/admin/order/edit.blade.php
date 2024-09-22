@extends('admin.layouts.master')

@section('title', 'Edit Coupon')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Edit Coupon</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.coupons.index')}}">Coupons</a></div>
        <div class="breadcrumb-item">Edit Coupon</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Edit Coupon</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Edit Coupon</h4>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('admin.coupons.update', ['coupon' => $coupon])}}">
                  @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{old('name', $coupon->name)}}" class="form-control">
                        @error('name')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" name="code" value="{{old('code', $coupon->code)}}" class="form-control">
                        @error('code')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" value="{{old('quantity', $coupon->quantity)}}" class="form-control">
                        @error('quantity')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label>Max use per person</label>
                      <input type="number" name="max_use" value="{{old('max_use', $coupon->max_use)}}" class="form-control">
                      @error('max_use')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="text" name="start_date" value="{{old('start_date', $coupon->start_date)}}" class="form-control datepicker">
                            @error('start_date')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>End Date</label>
                          <input type="text" name="end_date" value="{{old('end_date', $coupon->end_date)}}" class="form-control datepicker">
                          @error('end_date')
                              <code>{{$message}}</code>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Discount Type</label>
                            <select name="discount_type" class="form-control select2">
                              <option value="percentage" @selected(old('discount_type', $coupon->discount_type) == 'percentage') >Percentage (%)</option>
                              <option value="amount" @selected(old('discount_type', $coupon->discount_type) == 'amount')>Amount ({{$settings->currency_icon}})</option>
                            </select>
                            @error('discount_type')
                                <code>{{$message}}</code>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                            <label>Discount Value</label>
                            <input type="number" name="discount_value" value="{{old('discount_value', $coupon->discount_value)}}" class="form-control">
                            @error('discount_value')
                                <code>{{$message}}</code>
                            @enderror
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control">
                        <option value="1" @selected(old('status', $coupon->status) == '1') >Active</option>
                        <option value="0" @selected(old('status', $coupon->status) == '0')>Inactive</option>
                      </select>
                      @error('status')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                </form>
                 
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection