@extends('admin.layouts.error')
@section('title', '404')
@section('content')
<section class="section">
  <div class="container mt-5">
    <div class="page-error">
      <div class="page-inner">
        <h1>404</h1>
        <div class="page-description">
          The page you were looking for could not be found.
        </div>
        <div class="page-search">
          <div class="mt-3">
            <a href="{{route('login')}}">Back to Home</a>
          </div>
        </div>
      </div>
    </div>
    <div class="simple-footer mt-5">
      Trendy Treasures by <a href="https://nahyomeecodes.com"> NahyomeeCodes</a>
    </div>
  </div>
</section>
@endsection