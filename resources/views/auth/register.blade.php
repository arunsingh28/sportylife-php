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
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">
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
         .parent{
         overflow: hidden;margin-top:20px;
         }
         .child {
         float: left;
         margin-right: 15px;
         text-align: center;
         line-height: 18px;
         cursor: pointer;
         background-color: transparent;
         padding: 6px 20px;
         border-radius: 22px;
         border: 1px solid #848C97;
         color: #fff;
         }
         .child.bak img {
         filter: invert(1);
         }
         .bak{ 
         background-color: #fff;
         color: #000;
         }
         .parent h6 {
         color: #fff;
         text-align: left;
         font-size: 16px;
         }
         select.one {
         border: 1px solid #ccc;
         background: url("assets/img/arr.png")
         no-repeat;
         border: 1px solid #6d6d6d;
         width: 100%;
         color: #a8a8a8;
         border-radius: 35px;
         font-size: 13px;
         height: 50px;
         margin-top: 15px;
         outline: none;
         padding: 15px 15px;
         }
         select.one,
         select.two,
         select.three {
         background-size: 16px;
         background-position: calc(100% - 20px) 17px;
         background-repeat: no-repeat;
         }
         select {
         width: 100%;
         -webkit-appearance: none;
         -moz-appearance: none;
         appearance: none;
         padding: 10px;
         margin: 20px 0;
         }
         .height {
         background: #373737;
         border: 1px solid #6D6D6D;
         border-radius: 30px;
         line-height: 50px;
         }
         .height input.otp {
         background: transparent;
         text-align: center;
         color: #ffff;
         border-bottom: none;
         border-top: none;
         border-right-color: #6d6d6d;
         border-left: none;
         outline: none;
         /* height: 30px; */
         width: 40%;
         }
         h6.hgt_sec {
         color: #fff;
         text-align: left;
         font-size: 16px;
         margin-top: 15px;
         }
         .select2-container--default .select2-selection--single {
         background-color: #373737 !important;
         border: 1px solid #6D6D6D !important;
         border-radius: 37px !important;
         height: 49px !important;
         width: 100% !important;
         }
         .select2-container--default .select2-selection--single .select2-selection__rendered {
         color: white !important;
         line-height: 49px !important;
         }
         .select2-container--default .select2-selection--single .select2-selection__arrow {
         height: 26px !important;
         position: absolute !important;
         top: 11px !important;
         right: 18px !important;
         width: 20px !important;
         }
         .datepicker table tr td.day:hover, .datepicker table tr td.day.focused {
         background: #ef4234 !important;
         cursor: pointer;
         color: white;
         }
         .datepicker-dropdown {
         color: white !important;
         background: #212121 !important;
         }
         .datepicker .datepicker-switch:hover, .datepicker .prev:hover, .datepicker .next:hover, .datepicker tfoot tr th:hover,.datepicker table tr td span:hover, .datepicker table tr td span.focused {
         background: #ef4234 !important;
         height: 37px;
         }
         .datepicker table tr td.day, .datepicker table tr td.day:hover, .datepicker table tr td.day.focused {
         padding: 7px;
         }
         .datepicker .datepicker-switch, .datepicker .datepicker-switch:hover{
         height: 37px;
         }
         .float-left{
            float: left;
         }
         #expertrons_pop_up {
            right: 54px !important;
        }
        .validation-sapn {
         display: block;
    color: #fff;
    float: none;
    text-align: left;
        }
        .star-wh{
            color: red;
           
        }
      </style>
   </head>
   <body>
      <main id="main">
         <section class="login" style="height: auto;">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-lg-6 col-md-12 p-0 text-end">
                     <div class="mbl-img">
                        <img src="{{asset('web/assets/img/splash image.png')}}" class="img-fluid" alt="">
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-12 text-center logn-rght" style="height: auto;">
                     <!-- <img src="{{asset('web/assets/img/logo.png')}}" class="img-fluid" alt=""> -->
                     <!-- <a href="index.html"> <img src="assets/img/logo.png" class="img-fluid" alt=""> </a> -->
                     <div class="sign_up">
                        <h3>Sign Up</h3>
                        <form role="form" method="POST" action="{{ route('signup') }}">
                           @csrf
                           <div class="form-group">    
                           <span class="validation-sapn">Name<span class="star-wh">*</span></span>            
                              <input id="first_name" type="text" name="first_name" value="{{old('first_name')}}" class="form-control" placeholder="Name" required="required">                         
                      
                           </div>
                           <!-- <div class="form-group">                
                              <input id="last_name" type="text" name="last_name" value="{{old('last_name')}}" class="form-control" placeholder="Last Name" required="required"> 
                              <span class="validation-sapn">* Last Name </span>                        
                           </div> -->
                           <div class="form-group">      
                           <span class="validation-sapn">Email<span class="star-wh">*</span></span>            
                              <input id="email" type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Email ID" required="required"> 
                                                    
                           </div>
                           <div class="form-group">
                              <span class="validation-sapn">Country Code <span class="star-wh">*</span></span>  
                              <select class="one mb-0 mt-0 js-example-basic-single" name="country_code" value="{{old('country_code')}}" id="country_code">
                                 <option selected="selected" value=""> Select Country </option>
                                 @foreach($phonecode_data as $item)
                                 <option value="{{$item->phone_code}}" <?php if($item->phone_code == "+91"){echo "selected";}?>>{{$item->country_name}} ({{$item->phone_code}})</option>
                                 @endforeach
                              </select>        
                           </div>
                           <div class="form-group">  
                           <span class="validation-sapn">Phone<span class="star-wh">*</span></span>               
                              <input id="phone" type="text" name="phone" oninput='digitValidate(this)' class="form-control" value="{{old('phone')}}" placeholder="Phone" required="required">     
                                                   
                           </div>
                           <!-- <div class="form-group">
                           <span class="validation-sapn">DOB<span class="star-wh">*</span></span> 
                              <input id="dob" type="text" autocomplete="off" onchange="getUserAge()" value="{{old('dob')}}" name="dob" class="form-control" placeholder="dd-mm-yyyy" required="required">                         
                              <p style="color:white;text-align: left;" class="mt-1" id="ageText"></p>      
                           </div> -->
                           <div class="form-group ">
                           <span class="validation-sapn">Gender<span class="star-wh">*</span></span>
                              <div class="parent" >
                                 <!-- <h6>Gender</h6> -->
                                 <label class="child bak" for="male">
                                 <img src="{{asset('web/assets/img/toilet.svg')}}"> 
                                 Male
                                 </label>
                                 <input type="radio" id="male" checked name="gender" value="male" style="display:none;">
                                 <label class="child" for="female">
                                 <img src="{{asset('web/assets/img/female.svg')}}"> 
                                 Female
                                 </label>
                                 <input type="radio" id="female" name="gender" value="female" style="display:none;">
                                 <label class="child" for="other">
                                 <img src="{{asset('web/assets/img/other.svg')}}"> 
                                 Other
                                 </label>
                                 <input type="radio" id="other" name="gender" value="gender" style="display:none;">
                                 <!-- <div class="child"> <img src="{{asset('web/assets/img/other.svg')}}"> Other</div> -->
                              </div>>        
                           </div>
                           <!-- <div class="form-group" >
                              <h6 class="hgt_sec">Height Type</h6>
                              <select name="height_type" required value="{{old('height_type')}}" class="one mb-0 mt-0" id="height_type">
                                 <option value="Centimeter" selected>Centimeter</option>
                              </select>
                              </div> -->
                           <!-- <div class="form-group mt-5">
                              <h6 class="hgt_sec">Height</h6>
                              <div class="height">
                                 <input name="height_type" value="Centimeter" type="hidden">
                                 <input class="otp" id="height_feet" oninput='digitValidateCM(this)' name="height_feet" type="text" placeholder="cm" maxlength="3">
                                 <input class="otp" id="height_inch" oninput='digitValidateMM(this)' name="height_inch" style="border-right: none;" type="text"  placeholder="mm" maxlength="2">
                              </div>
                              <span class="validation-sapn">* Height </span>        
                           </div> -->
                           <!-- <div class="form-group" >
                              <h6 class="hgt_sec">Weight Type</h6>
                              <select name="weight_type" required value="{{old('weight_type')}}" class="one mb-0 mt-0" id="weight_type">
                                 <option value="Kilogram">Kilogram</option>
                              </select>
                              </div> -->
                           <!-- <h6 class="hgt_sec mt-5">Weight</h6>
                           <div class="form-group" style="position: relative;">
                              <input name="weight_type" value="Kilogram" type="hidden">
                              <input id="weight" type="text" pattern="\d{1,3}(\.\d{1,2})?$" value="{{old('weight')}}" name="weight" class="form-control" placeholder="Weight"> 
                              <h6 class="kg" id="kgtext" style="width: 30% !important;">KG</h6>
                              <span class="validation-sapn">* Weight </span>        
                           </div> -->
                           <!-- <div class="form-group mt-5">
                              <input id="state" type="text" name="state" value="{{old('state')}}" class="form-control" placeholder="State">   
                              <h6 class="hgt_sec">State</h6>
                              <select class="one mb-0 mt-0 js-example-basic-single" name="state" value="{{old('state')}}" id="state">
                                 <option selected="selected" value=""> Select State </option>
                                 @foreach($state_data as $item)
                                 <option value="{{$item->name}}">{{$item->name}}</option>
                                 @endforeach
                              </select>
                              <span class="validation-sapn">* State </span>        
                           </div> -->
                           <!-- <div class="form-group mt-5">
                              <input id="city" type="text" name="city" value="{{old('city')}}" class="form-control" placeholder="City">                         
                              <h6 class="hgt_sec">City</h6>
                              <select class="one mb-0 mt-0 js-example-basic-single" name="city" value="{{old('city')}}" id="city">
                                 <option selected="selected" value=""> Select City </option>
                                 @foreach($city_data as $item)
                                 <option value="{{$item->name}}">{{$item->name}}</option>
                                 @endforeach
                              </select>
                              <span class="validation-sapn">* City </span>        
                           </div> -->
                           {{-- <div class="form-group">
                              <h6 class="hgt_sec">School Name</h6>
                              <input id="school_name" type="text" name="school_name" class="form-control" placeholder="School Name">
                           </div>
                           <div class="form-group">
                              <h6 class="hgt_sec">School Address</h6>
                              <textarea id="school_address" style="border-radius: 15px;height: auto;padding: 14px;" name="school_address" class="form-control" placeholder="School Address" rows="5" cols="5"></textarea>
                           </div> --}}
                           <!-- <div class="form-group mt-5">
                              <h6 class="hgt_sec">Unique Number</h6>
                              <input id="school_unique_id" type="text" name="school_unique_id" class="form-control" placeholder="Unique Number">
                           </div> -->
                           <!-- <div class="form-group">
                              <h6 class="hgt_sec">Pin Code</h6>
                              <input id="zipcode" type="text" name="zipcode" class="form-control" placeholder="Zip Code">
                           </div> -->
                           <input type="hidden" name="language_id" value="1">
                           <!-- <div class="form-group">
                              <select class="one" name="language_id" value="{{old('language_id')}}" id="language_id">
                                 <option selected="selected" value=""> Preferred languages </option>
                                 @foreach($languages as $item)
                                 <option value="{{$item->id}}">{{$item->language_title}}</option>
                                 @endforeach
                              </select>
                           </div> -->
                           <!-- <div class="form-group">                
                              <input id="refer_by" type="text" style="margin-top: 0px;" value="{{old('refer_by')}}" name="refer_by" class="form-control" placeholder="Referral code / Unique number">                         
                           </div> -->
                           <div class="form-group" style="position: relative;">
                           <span class="validation-sapn">Password<span class="star-wh">*</span></span>
                              <input id="password" type="Password" name="password" class="form-control" placeholder="Set Password" required="required" >
                              {{-- <input id="password" type="Password" name="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Set Password" required="required" > --}}
                               
                              <h6 class="kg"  onclick="showpassword()" id="eyeopt"  style="    top: 49px;"><i  class="fa fa-eye-slash"></i></h6>
                              <!-- <h6 class="kg"  onclick="showpassword()" id="eyeopt"><i  class="fa fa-eye"></i></h6> -->
                              {{-- <h6 class="hgt_sec mt-5" style="font-size:14px !important;">Password must contain the following: <br> A <b>lowercase</b> letter , A <b>capital (uppercase)</b> letter, A <b>number</b>, Minimum <b>8 characters</b></h6> --}}
                           </div>
                           <div class="form-group" style="position: relative;">
                              <input id="password_confirmation" type="Password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required="required">      
                              <h6 class="kg"  onclick="showconfirmpassword()" id="eyeoptchange"  style="top: 10px;"><i  class="fa fa-eye-slash"></i></h6>
                           </div>
                           <a href="#!">   <input type="submit" class="btn-send" value="Confirm"> </a>
                           <p class="mt-4">* By Continuing you agree to the <a target="_blank" href="{{url('terms-conditions')}}"><u>Terms and Conditions</u></a> and <a target="_blank" href="{{url('privacy-policy')}}"><u>Privacy Policy</u></a></p>
                           <div class="login-or">
                              <hr class="hr-or">
                              <span class="span-or">or</span>
                           </div>
                        </form>
                        <!-- <div class="row mt-3">
                           <div class="col-xs-6 col-sm-6 col-md-6 col-6">
                              <button class="btn-cancel-action">   <img src="{{asset('web/assets/img/search_a.png')}}" class=""> Google</button>
                           </div>
                           <div class="col-xs-6 col-sm-6 col-md-6 col-6">
                              <button class="btn-cancel-action">   <img src="{{asset('web/assets/img/yahoo.png')}}" class=""> Yahoo</button>
                           </div>
                           </div> -->
                        <p class="mt-4">Already have an account? <a style="" href="{{route('login')}}"> <b> Login </b> </a></p>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </main>
      <!-- End #main -->
      <a  class="back-to-top d-flex align-items-center justify-content-center"><i class="fa fa-arrow-up"></i></a>
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
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
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
         function showconfirmpassword() {
           var x = document.getElementById("password_confirmation");
           if (x.type === "password") {
              x.type = "text";
              $("#eyeoptchange").html("<i class='fa fa-eye' ></i>")
           } else {
              x.type = "password";
              $("#eyeoptchange").html("<i class='fa fa-eye-slash' ></i>")
           }
         }
         $('#dob').datepicker({
           format:"dd-mm-yyyy",
           autoclose: true
         });
         @if($errors->any())
           // {!! implode('', $errors->all('<div class="alert alert-warning" role="alert">:message</div>')) !!}
           @foreach ($errors->all() as $error)
              var abc = '<?php echo $error; ?>';
              console.log(abc);
              toastr.options = {"progressBar": true}
              toastr.error(abc)
           @endforeach
         @endif
         @if(Session() -> has('success'))
         toastr.options = {"progressBar": true}
         toastr.success('{{ Session('success ') }}')
         
         @endif
         @if(Session() -> has('info'))
         toastr.options = {"progressBar": true}
         toastr.info('{{ Session('info') }}')
         @endif
         @if(Session() -> has('error'))
         toastr.options = {"progressBar": true}
         toastr.error('{{ Session('error') }}')
         @endif
         @if(Session() -> has('warning'))
         toastr.options = {"progressBar": true}
         toastr.warning('{{ Session('warning') }}')
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
         // document.getElementById("myBtn").onclick = function () {myFunction();};
         
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
         var elements = document.getElementsByClassName("child");
         
         for(var i = 0; i < elements.length; i++)
         {
         elements[i].onclick = function(){
            // remove class from sibling
            var el = elements[0];
            while(el)
            {
                if(el.tagName === "LABEL"){
                    //remove class
                    el.classList.remove("bak");
                }
                // pass to the new sibling
                el = el.nextSibling;
            }
            this.classList.add("bak");  
            };
         }
                
         let digitValidate = function(ele){   
         //   console.log(ele.value);
           ele.value = ele.value.replace(/[^0-9]/g,'');
         }
         
         let digitValidateWeight = function(e){   
         //   ele.value = ele.value.replace(/[^0-9]/g,'');
         //   ele.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 4)) : t;
         //   ele.value = ele.value.replace(/[^[0-9]*(\.[0-9]{0,2})]/g,'');
            var t = e.value;
            console.log("length",t.length);
            console.log("value",t.indexOf("."));
            if(t.length > 3){
               if(t.length.value == "."){
                  console.log("1");
               }else{
                  console.log("2");
               }
            }
            // e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;

         }
         
         let digitValidateCM = function(e){
         //   console.log(ele.value);
            e.value = e.value.replace(/[^0-9]/g,''); 
            // e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 4)) : t;
         //   ele.value = ele.value.replace(/[^[0-9]*(\.[0-9]{0,2})]/g,'');
         }
         
         let digitValidateMM = function(e){
         //   console.log(ele.value);
            e.value = e.value.replace(/[^0-9]/g,'');
            // e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
         //   ele.value = ele.value.replace(/[^[0-9]*(\.[0-9]{0,2})]/g,'');
         }
         
         let tabChange = function(val){
           let ele = document.querySelectorAll('input');
           if(ele[val-1].value != ''){
             ele[val].focus()
           }else if(ele[val-1].value == ''){
             ele[val-2].focus()
           }   
         }
      </script>
      <script>
         function showpassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
               x.type = "text";
               $("#eyeopt").html("<i class='fa fa-eye'></i>")
            } else {
               x.type = "password";
               $("#eyeopt").html("<i class='fa fa-eye-slash'></i>")
            }
         }
         
         $(document).ready(function() {
            $('.js-example-basic-single').select2();
         });
         
          $("#weight_type").change(function () {
            $("#kgtext").html(this.value);
         });
          $("#height_type").change(function () {
             if (this.value == "Centimeter") {
                $("#height_feet").attr("placeholder",'cm');
                $("#height_inch").attr("placeholder",'mm');
             }else if (this.value == "Inch"){
                $("#height_feet").attr("placeholder",'Feet');
                $("#height_inch").attr("placeholder",'Inch');
         
             }else{
                $("#height_feet").attr("placeholder",'');
                $("#height_inch").attr("placeholder",'');
             }
         });
         function getUserAge() {
            var dob = $("#dob").val();
            $.ajax({
               url: "{{url('getUserAge')}}",
               type: 'post',
               dataType: 'json',
               data: {
                  'dob':dob,
               },
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               success: function(data){
                  if (data.statusCode == "200") {
                        $('#ageText').html("Age: "+data.age+" Years");
                  }else{
                        $('#ageText').html('');
                     }
                  },
                  error: function(){
                     
                  }
            });
         }
         // $(document).ready(function(){
         //     $.ajax({
         //         url: "{{url('api/languageList')}}",
         //         type: 'get',
         //         dataType: 'json',
         //         data: {},
         //         success: function(data){
         //             if (data.statusCode == "200") {
         //                 $(data.data).each(function( key, value ) {
         //                     $("#language_id").append('<option value='+value.id+'>'+value.language_title+'</option>')
         //                 });
         //             }else{
         //                 toastr.error(data.message)
         //             }
         //         },
         //         error: function(){
         //         }
         //     });
         // });
         function register() {
         var name = $('#name').val();
         var email = $('#email').val();
         var phone = $('#phone').val();
         var dob = $('#dob').val();
         var gender =  $(".bak").text().toLowerCase();
         var height_feet = $('#height_feet').val();
         var height_inch = $('#height_inch').val();
         var weight = $('#weight').val();
         var city = $('#city').val();
         var state = $('#state').val();
         var language_id = $('#language_id').val();
         var refer_by = $('#refer_by').val();
         var password = $('#password').val();
         var password_confirmation = $('#password_confirmation').val();
            $.ajax({
                url: "{{url('api/register')}}",
                type: 'post',
                dataType: 'json',
                data: {
                'name':name,
                'email':email,
                'phone':phone,
                'dob':dob,
                'height_feet':height_feet,
                'height_inch':height_inch,
                'weight':weight,
                'city':city,
                'state':state,
                'language_id':language_id,
                'refer_by':refer_by,
                'password':password,
                'password_confirmation':password_confirmation,
                
                },
                success: function(data){
                if (data.statusCode == "200") {
                    // toastr.success(data.message)
                    // //setsession
                    // $.ajax({
                    //     url: "{{url('/sessiondata')}}",
                    //     type: 'post',
                    //     dataType: 'json',
                    //     data: {
                    //     'data':data,
                    //     },
                    //     headers: {
                    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    //     },
                    //     success: function(data){
                    //     }
                    // });
                    // //setsession
                    window.location.href = "{{url('/index')}}";
                }else{
                    toastr.error(data.message)
                }
                },
                error: function(){
                }
            });
         }
      </script>
      {{-- <script src="https://b2b.expertrons.com/expertronsEmbedVideoBot/aiBotParentScript.js"                       id="expertons_video_bot_root"                      data-main="Mbp-5e96330e8a278ejgge004394"                      data-content="62fe2afd549e31476914f03e"></script> --}}
   </body>
</html>