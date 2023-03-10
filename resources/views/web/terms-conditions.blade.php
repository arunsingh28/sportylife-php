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
   </head>
   <body>
      <div class="forgot_page frequently_questions" style="margin-top: 0px !important;">
         <!-- <a href="#!" onclick="history.back()">
            <h5>  <img class="back" src="{{asset('web/assets/img/back.svg')}}"> Back </h5>
         </a> -->
         <div class="container">
            <h3> Terms & Conditions </h3>
            <div class="row">
               <div class="col-lg-12 col-md-12 private-pt">
                  <h2><strong>Terms &amp; Conditions</strong></h2>
                  {!! $data->value !!}
               </div>
            </div>
         </div>
      </div>
      <a class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
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
       <script>
         $('.back-to-top').click(function () {
            // $('#bi-arrow-up-short').tooltip('hide');
            $('body,html').animate({
               scrollTop: 0
            }, 1);
            return false;
         });
       </script>
   </body>
</html>