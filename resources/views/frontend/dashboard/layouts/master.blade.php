<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <title>{{$settings->site_name}} | @yield('title')</title>
  <link rel="icon" type="image/png" href="{{asset('frontend/images/favicon.png')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/slick.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/jquery.nice-number.min.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/jquery.calendar.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/add_row_custon.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/mobile_menu.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/jquery.exzoom.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/multiple-image-video.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/ranger_style.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/jquery.classycountdown.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/venobox.min.css')}}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.min.css">

  <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">
  <!-- <link rel="stylesheet" href="{{asset('frontend/css/rtl.css')}}"> -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>


  <!--=============================
    DASHBOARD MENU START
  ==============================-->
  <div class="wsus__dashboard_menu">
    <div class="wsusd__dashboard_user">
      <img src="{{asset('uploads/'.auth()->user()->image)}}" alt="img" class="img-fluid">
      <p>{{auth()->user()->name}}</p>
    </div>
  </div>
  <!--=============================
    DASHBOARD MENU END
  ==============================-->


  <!--=============================
    DASHBOARD START
  ==============================-->
  <section id="wsus__dashboard">
    <div class="container-fluid">
      @include('frontend.dashboard.layouts.sidebar')
      <div class="row">
       @yield('content')
      </div>
    </div>
  </section>
  <!--=============================
    DASHBOARD START
  ==============================-->


  <!--============================
      SCROLL BUTTON START
    ==============================-->
  <div class="wsus__scroll_btn">
    <i class="fas fa-chevron-up"></i>
  </div>
  <!--============================
    SCROLL BUTTON  END
  ==============================-->


  <!--jquery library js-->
  <script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
  <!--bootstrap js-->
  <script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
  <!--font-awesome js-->
  <script src="{{asset('frontend/js/Font-Awesome.js')}}"></script>
  <!--select2 js-->
  <script src="{{asset('frontend/js/select2.min.js')}}"></script>
  <!--slick slider js-->
  <script src="{{asset('frontend/js/slick.min.js')}}"></script>
  <!--simplyCountdown js-->
  <script src="{{asset('frontend/js/simplyCountdown.js')}}"></script>
  <!--product zoomer js-->
  <script src="{{asset('frontend/js/jquery.exzoom.js')}}"></script>
  <!--nice-number js-->
  <script src="{{asset('frontend/js/jquery.nice-number.min.js')}}"></script>
  <!--counter js-->
  <script src="{{asset('frontend/js/jquery.waypoints.min.js')}}"></script>
  <script src="{{asset('frontend/js/jquery.countup.min.js')}}"></script>
  <!--add row js-->
  <script src="{{asset('frontend/js/add_row_custon.js')}}"></script>
  <!--multiple-image-video js-->
  <script src="{{asset('frontend/js/multiple-image-video.js')}}"></script>
  <!--sticky sidebar js-->
  <script src="{{asset('frontend/js/sticky_sidebar.js')}}"></script>
  <!--price ranger js-->
  <script src="{{asset('frontend/js/ranger_jquery-ui.min.js')}}"></script>
  <script src="{{asset('frontend/js/ranger_slider.js')}}"></script>
  <!--isotope js-->
  <script src="{{asset('frontend/js/isotope.pkgd.min.js')}}"></script>
  <!--venobox js-->
  <script src="{{asset('frontend/js/venobox.min.js')}}"></script>
  <!--classycountdown js-->
  <script src="{{asset('frontend/js/jquery.classycountdown.js')}}"></script>
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.all.min.js"></script>


  <!--main/custom js-->
  <script src="{{asset('frontend/js/main.js')}}"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>"
  <script>
    $(document).ready(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      $('body').on('click', '.delete-btn', function(event){
        event.preventDefault()
        let url = $(this).attr('href')
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {

              $.ajax({
                type: 'DELETE',
                url: url,

                success: function(data){

                  if(data.status == 'success'){
                    swalWithBootstrapButtons.fire(
                      'Deleted!',
                      data.message,
                      'success'
                    )
                    window.location.reload()
                  }
                  if(data.status == 'error'){
                    swalWithBootstrapButtons.fire(
                      'Oops!',
                      data.message,
                      'error'
                    )
                  }
                },
                error: function(xhr, status, error) {
                  swalWithBootstrapButtons.fire(
                    'Oops!',
                    'Error deleting data.',
                    'error'
                  )
                }
              })
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              'Cancelled',
              'Your data is safe :)',
              'error'
            )
          }
        })
      })
    })
  </script>
  <script>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{$error}}')
        @endforeach
    @endif
  </script>
  @stack('scripts')
</body>

</html>