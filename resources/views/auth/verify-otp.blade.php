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
      <!-- <link href="https://use.typekit.net/wrn2kps.css" rel="stylesheet"> -->
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
      <style type="text/css">
         form input{
         display:inline-block;
         width:16.6%;
         height:30px;
         line-height:0;
         text-align:center;
         }
         .for_get .abc {
         background: #373737;
         border: 1px solid #6D6D6D;
         border-radius: 30px;
         line-height: 50px;
         display: flex;
         }
         .abc input:nth-child(8){
            border:none;
         }
         input.otp {
         background: transparent;
         text-align: center;
         color: #ffff;
         border-bottom: none;
         border-top: none;
         border-right-color: #6d6d6d;
         border-left: none;
         outline: none;
         }
         .for_get p {
         color: #fff;
         font-size: 14px;
         text-align: center;
         }
         @media (max-width: 991px){
            .for_get form input {
              width:16.6%;
            }

         }
      </style>
   </head>
   <body>
      <div class="forgot_page">
         <a href="#!" onclick="history.back()">
            <h5> <img class="back" src="{{asset('web/assets/img/back.svg')}}"> Back </h5>
         </a>
         <div class="container">
            <a href="#!"><img src="{{asset('web/assets/img/logo.png')}}" alt="" class="img-fluid"></a>
            <div class="row">
               <div class="col-lg-3 col-md-3"></div>
               <div class="col-lg-6 col-md-6"> 
                  <div class="for_get">
                     <h3 class="pb-0">Verify</h3>
                     <p>Enter the code we've sent to your email and mobile</p>
                     <!-- <div class="form-group">                
                        <input id="name" type="text" name="name" class="form-control" placeholder="New Password" required="required">                         
                        </div> -->
                     <form role="form" method="POST" action="{{ url('verify-otp') }}">
                       @csrf
                       <div class="abc">

                         <input type="hidden" name="email" value="{{ $email }}"/>
                         <input type="hidden" name="type" value="{{ $type }}"/>
                         <!-- <input class="otp" type="text" name="otp" maxlength="6" > -->
                         <input class="otp" type="text" name="otp[]" oninput='tabChange(4)'  maxlength=1 > 
                        <input class="otp" type="text" name="otp[]" oninput='tabChange(5)'  maxlength=1 > 
                        <input class="otp" type="text" name="otp[]" oninput='tabChange(6)'  maxlength=1 > 
                        <input class="otp" type="text" name="otp[]" oninput='tabChange(7)' maxlength=1 > 
                        <input class="otp" type="text" name="otp[]" oninput='tabChange(8)' maxlength=1 > 
                        <input class="otp" type="text" name="otp[]" oninput='tabChange(9)' maxlength=1 > 
                      </div>
                        <a href="#!">  
                          <input type="submit" class="btn-send" value="Verify"> 
                        </a>
                     </form>
                     <!-- <p class="mt-2">Haven't received an SMS? <a href="#"> Send again </a> </p> -->
                  </div>
               </div>
               <div class="col-lg-3 col-md-3"></div>
            </div>
         </div>
      </div>
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
      <script type="text/javascript">
         window.onpageshow = function (event) {
               if (event.persisted) {
                     window.location.reload();
               }
            };
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
      <script type="text/javascript">
         let digitValidate = function(ele){
           console.log(ele.value);
           ele.value = ele.value.replace(/[^0-9]/g,'');
         }
         
         let tabChange = function(val){
           let ele = document.querySelectorAll('input');
           console.log(ele[val-1].value);
           if(ele[val-1].value != ''){
             ele[val].focus()
           }else if(ele[val-1].value == ''){
             ele[val-2].focus()
           }   
         }
      </script>
      
      <script type="text/javascript">
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
   </body>
</html>