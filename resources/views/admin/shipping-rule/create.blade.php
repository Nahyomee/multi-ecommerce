@extends('admin.layouts.master')

@section('title', 'Create Shipping Rule')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Create Shipping Rule</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('admin.shipping-rules.index')}}">Shipping Rules</a></div>
        <div class="breadcrumb-item">Create Shipping Rule</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Create Shipping Rule</h2>

      <div class="row">
        <div class="col-12 ">
          <div class="card">
            <div class="card-header">
              <h4>Create Shipping Rule</h4>
            </div>
            <div class="card-body">
                @include('flash-message')
                <form method="post" action="{{route('admin.shipping-rules.store')}}">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control">
                        @error('name')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label>Type</label>
                      <select name="type" class="form-control select2 shipping_type">
                        <option value="flat_fee" @selected(old('type') == 'flat_fee') >Flat Fee </option>
                        <option value="min_cost" @selected(old('type') == 'min_cost')>Minimum Order Amount</option>
                      </select>
                      @error('type')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group min_cost">
                      <label>Minimum Cost</label>
                      <input type="number" name="min_cost" value="{{old('min_cost')}}" class="form-control">
                      @error('min_cost')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Cost</label>
                      <input type="number" name="cost" value="{{old('cost')}}" class="form-control">
                      @error('cost')
                          <code>{{$message}}</code>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control">
                        <option value="1" @selected(old('status') == '1') >Active</option>
                        <option value="0" @selected(old('status') == '0')>Inactive</option>
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

@push('scripts')
  <script>
    $(document).ready(function(){
      let type = $('.shipping_type').val()
      console.log(type)
      if(type != 'min_cost'){
        $('.min_cost').addClass('d-none')
      }
        $('body').on('change', '.shipping_type', function(){
          let type = $(this).val()

          if(type != 'min_cost'){
            $('.min_cost').addClass('d-none')
          }
          else{
            $('.min_cost').removeClass('d-none')

          }

        })
      })
  </script>
@endpush