
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    .contact-us-home{
       position: absolute;
    top: 0px;
    left: 0px;
    text-align: center;
    width: 100%;
    height: 100%;
    align-items: center;
    display: flex;
    justify-content: center;
}
.contact-us-home p{
   color:#fff;
   margin:0px;
}
.contact-us-home span{
   display:block;
   color:#f00;
}
#expertrons_pop_up {
            right: 54px !important;
        }
        .mini-bot {
            width: 60px !important;
            height: 60px !important;
        }
        .mini-bot .player {
            top: 4px !important;
            left: 4px !important;
            width: 52px!important;
            height: 52px!important;
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
              <img src="{{asset('web/assets/img/splash image.png')}}" class="img-fluid" alt="">
            </div>
          </div>
          <div class="col-md-6 text-center logn-rght">
            <img src="{{asset('web/assets/img/logo-updated3.png')}}"  style="max-width: 30% !important;" class="img-fluid" alt="">
            <h3>Login</h3>

            <div class="lgn-form">
              <form role="form" method="POST" action="{{ route('login') }}">
                @csrf
              <div class="form-group">
                <!-- <input type="text" class="form-control usr" placeholder="Email" id="inputUsernameEmail"> -->
                <input id="email" type="text" placeholder="Email/Mobile" class="form-control usr @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group" style="position: relative;">
                <!-- <input type="password" class="form-control pass" placeholder="Password" id="inputPassword"> -->
                <input id="password" type="password" placeholder="Password" class="form-control pass @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                 <h6 class="kg"  onclick="showpassword()" id="eyeopt" ><i  class="fa fa-eye-slash"></i></h6> 
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
               <span class="mt-2 mb-2" style="float:left;    color: white;">
                <input type="checkbox" name="remember_me"  id="remember_me"> Remember me
              </span>
              <button type="submit" class="lgn-btn"><a style="color:#000;"> Login </a></button>
              <!-- <button type="button" class="lgn-btn" onclick="login()"><a style="color:#000;"> Login </a></button> -->
              @if(session()->has('error'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ session()->get('message') }}</strong>
              </span>
              @endif
              <a class="frgt-pass" href="{{route('forgot-password')}}">Forgot password?</a>
              </form>

              <div class="login-or">
                <hr class="hr-or">
                <span class="span-or">or</span>
              </div>

              <!-- <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-6">
                  <a href="{{url('auth/google')}}"><button class="btn-cancel-action"> <img src="{{asset('web/assets/img/search_a.png')}}" class=""> Google</button></a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-6">
                  <a href="{{url('auth/yahoo')}}"><button class="btn-cancel-action"> <img src="{{asset('web/assets/img/yahoo.png')}}" class=""> Yahoo</button></a>
                </div>
              </div> -->
              <p style="color:#fff;" class="mt-3">Don't have a account? <a href="{{ route('signup') }}"> <b> Sign Up </b> </a></p>

              <div class="dnwd-btn">
                <h4>Download the app today</h4>
                <a href="https://play.google.com/store/apps/details?id=com.sporty_life_app" target="_blank"><img src="{{asset('web/assets/img/google_play-logo.svg')}}" class="img-fluid" alt=""></a>
                <a href="https://apps.apple.com/in/app/sporty-life/id1611151967" target="_blank"><img src="{{asset('web/assets/img/play-store-logo.svg')}}" class="img-fluid" alt=""></a>
              </div>
                     <div class="free-trial mt-3" style="position:relative;">
                        <img src="{{asset('web/assets/img/live_bg.png')}}" alt="" class="img-fluid" style="width:100%;height:100%;border: 3px solid gray;border-radius: 16px;">
                        <div class="contact-us-home">
                         <div>
                             <p>Contact Us on</p>
                           <span>080 69444044</span>
                           {{-- <a href="tel:080 69444044">080 69444044</a> --}}
                         </div>

                        </div>

                     </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <a class="back-to-top d-flex align-items-center justify-content-center"><i class="fa fa-arrow-up"></i></a>
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

    $('.back-to-top').click(function () {
      // $('#bi-arrow-up-short').tooltip('hide');
      $('body,html').animate({
          scrollTop: 0
      }, 1);
      return false;
    });
    
    function showpassword() {
      var x = document.getElementById("password");
      if (x.type === "password") {
          x.type = "text";
          $("#eyeopt").html("<i class='fa fa-eye'></i>")
      } else {
          x.type = "password";
          $("#eyeopt").html("<i class='fa fa-eye-slash' ></i>")
      }
    }
    @if(Session() -> has('success'))
    toastr.options = {
      "progressBar": true
    }
    toastr.success('{{ Session('success') }}')
    @endif
    @if(Session() -> has('info'))
    toastr.options = {
      "progressBar": true
    }
    toastr.info('{{ Session('info') }}')
    @endif
    @if(Session() -> has('error'))
    toastr.options = {
      "progressBar": true
    }
    toastr.error('{{ Session('error') }}')
    @endif
    @if(Session() -> has('warning'))
    toastr.options = {
      "progressBar": true
    }
    toastr.warning('{{ Session('warning') }}')
    @endif
  </script>

  <script type="text/javascript">
    $('#myNavTabs a').click(function(evt) {
      evt.preventDefault();
      $(this).tab('show');
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      //new tab
      console.log(e.target);

      //previous tab
      console.log(e.relatedTarget);
    })
  </script>
  <script type="text/javascript">
    // Get the button, and when the user clicks on it, execute myFunction
    

    /* myFunction toggles between adding and removing the show class, which is used to hide and show the dropdown content */
    function myFunction() {
      document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {

      if (!event.target.matches('.dropbtn')) {

        var dropdowns = document.getElementsByClassName("dropdown-content");

        for (let i = 0; i < dropdowns.length; i++) {
          if (window.CP.shouldStopExecution(0)) break;
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
        window.CP.exitedLoop(0);
      }
    }; 
    
  </script>
  <script>
    function login() {
      var email = $('#email').val();
      var password = $('#password').val();
          $.ajax({
            url: "{{url('api/login')}}",
            type: 'post',
            dataType: 'json',
            data: {
              'email':email,
              'password':password,
            },
            success: function(data){
              if (data.statusCode == "200") {
                // toastr.success(data.message)
                //setsession
                  $.ajax({
                    url: "{{url('/sessiondata')}}",
                    type: 'post',
                    dataType: 'json',
                    data: {
                      'data':data,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                    }
                  });
                //setsession
                window.location.href = "{{url('/index')}}";
              }else{
                toastr.error(data.message)
              }
            },
            error: function(){
            }
          });
    }

    // $(window).on('load', function() {
        
    // })
    
    // $(document).ready(function () {
    //     $.ajax({
    //       url: "{{url('/checkuserlogin')}}",
    //       type: 'get',
    //       dataType: 'json',
    //       data: {},
    //       success: function(res){
    //         console.log(res);
    //         // if (res.statusCode == "200") {
    //           // }
    //           window.location.href = "{{url('/index')}}";
    //       }
    //     });
    // });
    
    
    
  </script>
  {{-- <script src="https://b2b.expertrons.com/expertronsEmbedVideoBot/aiBotParentScript.js"                       id="expertons_video_bot_root"                      data-main="Mbp-5e96330e8a278ejgge004394"                      data-content="62fe2afd549e31476914f03e"></script> --}}
</body>

</html>