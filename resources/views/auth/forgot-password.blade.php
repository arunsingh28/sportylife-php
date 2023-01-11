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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
         #expertrons_pop_up {
            right: 54px !important;
        }
      </style>
   </head>
   <body>
      <div class="forgot_page">
      <a href="#!" onclick="history.back()">
         <h5>  <img class="back" src="{{asset('web/assets/img/back.svg')}}"> Back </h5>
      </a>
      <div class="container">
         <a href="#!"><img src="{{asset('web/assets/img/logo.png')}}" alt="" class="img-fluid"></a>
         <div class="row">
            <div class="col-lg-4 col-md-0"></div>
            <div class="col-lg-4 col-md-12">
               <div class="for_get">
                  <h3>Forgot Password</h3>
                  <form role="form" method="POST" action="{{ url('forgot-password') }}">
                    @csrf
                    <div class="form-group">                
                        <input style="width: -webkit-fill-available;" id="email" type="email" name="email" class="form-control" placeholder="Enter your registered email" required="required">                         
                    </div>
                    <a href="#!"> <input type="submit" class="btn-send" value="Submit"> </a>
                  </form>
               </div>
               <div class="col-lg-4 col-md-0"></div>
            </div>
         </div>
      </div>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="fa fa-arrow-up"></i></a>
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
        <script type="text/javascript">
           window.onpageshow = function (event) {
               if (event.persisted) {
                     window.location.reload();
               }
            };
            @if($errors->any())
                // {!! implode('', $errors->all('<div class="alert alert-warning" role="alert">:message</div>')) !!}
                @foreach ($errors->all() as $error)
                var abc = '<?php echo $error; ?>';
                console.log(abc);
                toastr.options = {"progressBar": true}
                toastr.error(abc)
                @endforeach
            @endif
            @if(Session()->has('success'))
            toastr.options = {"progressBar": true}
            toastr.success('{{ Session('success') }}')
            @endif
            @if(Session() -> has('info'))
            toastr.options = {
            "progressBar": true
            }
            toastr.info('{{ Session('info') }}')
            @endif
            @if(Session()->has('error'))
            toastr.options = {
            "progressBar": true
            }
            toastr.error('{{ Session('error') }}')
            @endif
            @if(Session() -> has('warning'))
            toastr.options = {
            "progressBar": true
            }
            toastr.warning('{{ Session('
            warning ') }}')
            @endif
        </script>
      <script type="text/javascript">
         $('#myNavTabs a').click(function (evt) {
           evt.preventDefault();
           $(this).tab('show');
         });
         
         $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
               //new tab
               console.log(e.target);
               
               //previous tab
               console.log(e.relatedTarget);
             })
           
      </script>
      <script type="text/javascript">
         // Get the button, and when the user clicks on it, execute myFunction
         document.getElementById("myBtn").onclick = function () {myFunction();};
         
         /* myFunction toggles between adding and removing the show class, which is used to hide and show the dropdown content */
         function myFunction() {
           document.getElementById("myDropdown").classList.toggle("show");
         }
         
         // Close the dropdown if the user clicks outside of it
         window.onclick = function (event) {
           
           if (!event.target.matches('.dropbtn')) {
             
            var dropdowns = document.getElementsByClassName("dropdown-content");
            
            for (let i = 0; i < dropdowns.length; i++) {if (window.CP.shouldStopExecution(0)) break;
              var openDropdown = dropdowns[i];
              if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
              }
            }window.CP.exitedLoop(0);
          }
         };
      </script>
      {{-- <script src="https://b2b.expertrons.com/expertronsEmbedVideoBot/aiBotParentScript.js"                       id="expertons_video_bot_root"                      data-main="Mbp-5e96330e8a278ejgge004394"                      data-content="62fe2afd549e31476914f03e"></script> --}}
   </body>
</html>