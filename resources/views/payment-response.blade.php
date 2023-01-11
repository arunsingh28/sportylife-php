<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sporty Life</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="{{asset('web/assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('web/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://use.typekit.net/wrn2kps.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- Vendor CSS Files -->
  <link href="{{asset('web/assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('web/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('web/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('web/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('web/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('web/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('web/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('web/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{asset('web/assets/css/style.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <style>
    ::-webkit-scrollbar {
      width: 5px;
      height: 5px;
      /* display: none; */
    }

    ::-webkit-scrollbar-track {
      background: var(--lightestgrey);
    }

    ::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
  </style>
</head>

<body>

  <main id="main">
    <section class="login">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 p-0 text-end">
            <div class="mbl-img">
              <img src="{{asset('web/assets/img/mobile-img1.png')}}" class="img-fluid" alt="">
            </div>
          </div>
          <div class="col-md-6 text-center logn-rght">
            <img src="{{asset('web/assets/img/logo.png')}}" class="img-fluid" alt="">
            @if($status == "1")
            <h3 class="mt-3">Payment Successful !!!</h3>
            <img src="{{asset('/uploads/success.gif')}}" class="img-fluid mt-5" alt="">
            <p class="mt-5">  <a href="{{route('index')}}" style="color:#212121"><button class="add_cart fre-trl"> Go to Home </button></a></p>
            @else
            <h3 class="mt-3" style="color:#ef4234;">Payment Failed!</h3>
            <img style="height: 29% !important;" src="{{asset('/uploads/failed.gif')}}" class="img-fluid mt-5" alt="">
            <p class="mt-5">  <a href="{{route('cart')}}" style="color:#212121"><button class="add_cart fre-trl"> Continue Shopping </button></a></p>
            @endif
          </div>
        
        </div>
        
      </div>
    </section>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Vendor JS Files -->
  <script src="{{asset('web/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('web/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('web/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('web/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('web/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('web/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <script src="{{asset('web/assets/vendor/php-email-form/validate.js')}}"></script>
  <!-- Template Main JS File -->
  <script src="{{asset('web/assets/js/main.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

 
</body>

</html>