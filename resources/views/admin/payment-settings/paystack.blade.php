<div class="card border">
    <div class="card-body">
        <form action="{{route('admin.paystack-settings.update')}}" method="post">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>Default Currency</label>
                <select name="currency" class="form-control select2">
                    <option value="">Select Currency</option>
                    @foreach (config('settings.currency_list') as $full => $currency)
                        @if(in_array($currency, ['NGN']))
                            <option value="{{$currency}}"  @selected(old('currency', $paystack_settings?->currency) == $currency)>{{$full}}({{$currency}})</option>
                        @endif
                     @endforeach
                </select>
                @error('currency')
                    <code>{{$message}}</code>
                @enderror
            </div>
            <div class="form-group">
                <label>Exchange rate with {{$settings->currency_icon}}</label>
                <input type="number" class="form-control" name="rate" value="{{old('rate', $paystack_settings?->rate)}}">
                @error('rate')
                    <code>{{$message}}</code>
                @enderror
            </div>
            <div class="form-group">
                <label>Public Key</label>
                <input type="text" class="form-control" name="public_key" value="{{old('public_key', $paystack_settings?->public_key)}}">
                @error('public_key')
                    <code>{{$message}}</code>
                @enderror
            </div>
            <div class="form-group">
                <label>Secret Key</label>
                <input type="text" class="form-control" name="secret_key" value="{{old('secret_key', $paystack_settings?->secret_key)}}">
                @error('secret_key')
                    <code>{{$message}}</code>
                @enderror
            </div>
            <button class="btn btn-primary mr-1" type="submit">Update</button>
            <button class="btn btn-secondary" type="reset">Reset</button>
        </form>
    </div>
</div>