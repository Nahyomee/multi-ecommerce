@if ($message = Session::get('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">

	<div class="alert-body">
        <button class="close" data-dismiss="alert"><span>&times;</span> </button>
    
        <strong>{{ $message }}</strong>
    </div>

</div>

@endif



@if ($message = Session::get('error'))

<div class="alert alert-danger alert-dismissible fade show" role="alert">

	<div class="alert-body">
        <button class="close" data-dismiss="alert"><span>&times;</span> </button>
    
        <strong>{{ $message }}</strong>
    </div>

</div>

@endif



@if ($message = Session::get('warning'))

<div class="alert alert-warning alert-dismissible fade show" role="alert">

	<div class="alert-body">
        <button class="close" data-dismiss="alert"><span>&times;</span> </button>
    
        <strong>{{ $message }}</strong>
    </div>

</div>

@endif



@if ($message = Session::get('info'))

<div class="alert alert-info alert-dismissible fade show" role="alert">
    <div class="alert-body">
        <button class="close" data-dismiss="alert"><span>&times;</span> </button>
    
        <strong>{{ $message }}</strong>
    </div>

</div>

@endif



@if ($errors->any())

<div class="alert alert-danger alert-dismissible fade show" role="alert">

	<div class="alert-body">
        <button class="close" data-dismiss="alert"><span>&times;</span> </button>
        Please check the form below for errors
    </div>

</div>

@endif