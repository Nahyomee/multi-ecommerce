<div class="card border">
    <div class="card-body">
        <form action="{{route('admin.general-settings.update')}}" method="post">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>Site Name</label>
                <input type="text" class="form-control" name="site_name" value="{{old('site_name', $general_settings?->site_name)}}">
                @error('site_name')
                    <code>{{$message}}</code>
                @enderror
            </div>
            <div class="form-group">
                <label>Layout</label>
                <select name="layout" class="form-control">
                    <option value="ltr" @selected(old('layout', $general_settings?->layout) == "ltr")>LTR</option>
                    <option value="trl" @selected(old('layout', $general_settings?->layout) == "rtl")>RTL</option>
                </select>
                @error('layout')
                    <code>{{$message}}</code>
                @enderror
            </div>
            <div class="form-group">
                <label>Contact Email</label>
                <input type="email" class="form-control" name="contact_email" value="{{old('contact_email', $general_settings?->contact_email)}}">
                @error('contact_email')
                    <code>{{$message}}</code>
                @enderror
            </div>
            <div class="form-group">
                <label>Default Currency</label>
                <select name="currency" class="form-control select2">
                    <option value="">Select Currency</option>
                    @foreach (config('settings.currency_list') as $full => $currency)
                        <option value="{{$currency}}"  @selected(old('currency', $general_settings?->currency) == $currency)>{{$full}}({{$currency}})</option>
                    @endforeach
                </select>
                @error('currency')
                    <code>{{$message}}</code>
                @enderror
            </div>
            <div class="form-group">
                <label>Currency Icon</label>
                <input name="currency_icon" class="form-control" value="{{old('currency_icon', $general_settings?->currency_icon)}}">
                @error('currency_icon')
                    <code>{{$message}}</code>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Timezone</label>
                <select name="timezone" class="form-control select2">
                    <option value="">Select Timezone</option>
                    @foreach (config('settings.timezones') as $region => $zones)
                        <optgroup label="{{$region}}">
                            @foreach ($zones as $tz => $zone)
                                <option value="{{$tz}}" @selected(old('timezone', $general_settings?->timezone) == $tz)>{{$tz}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('timezone')
                    <code>{{$message}}</code>
                @enderror
            </div>
            <button class="btn btn-primary mr-1" type="submit">Update</button>
            <button class="btn btn-secondary" type="reset">Reset</button>
        </form>
    </div>
</div>