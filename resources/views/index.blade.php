@extends('layouts.main')
@section('style')
<style>
.free-trial{
   position: relative;
   height: 100%;
}
.free-trial .free-plan{
   position: absolute;
    left: 20px;
    width: 100%;
    bottom: 15px;
}
.free-trial .free-plan p{
   color:#fff;
   font-size:22px;
   margin:0;
}
.free-trial .free-plan a{
   color:#EF4234;
}
.free-trial .free-plan a:hover{
   color:#EF4234;
}
.freetrial-popup {
    /* margin-top: 0; */
    max-width: 1000px;
    margin: auto !important;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    height: 100%;
}
.modal {
    top: 30px !important;
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
</style>
@endsection
@section('content')
<!-- ======= Hero Section ======= -->
<section id="hero">
   <div id="heroCarousel" data-bs-interval="3000" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <div class="carousel-inner" role="listbox">
         <!-- Slide 1 -->
         @foreach($sliders as $key => $item)
         <div class="carousel-item <?php if ($key == "0") {echo "active";}?>">
            <div class="row">
               <div class="col-md-6">
                  <div class="carousel-container">
                     <div class="carousel-content animate__animated animate__fadeInLeft">
                        <h2>{{$item->title}}</h2>
                        <p>{{$item->description ?? ''}} </p>
                        <a href="{{route('services')}}" class="btn-get-started">Start Now <img src="{{asset('web/assets/img/right-aro.svg')}}" alt=""></a>
                        {{-- <a href="#startnow" class="btn-get-started">Start Now <img src="{{asset('web/assets/img/right-aro.svg')}}" alt=""></a> --}}
                     </div>
                  </div>
               </div>
               {{-- <div class="col-md-6">
                  @if($item->redirect_to == "frc")
                  <a href="{{route('frc')}}">
                  @elseif($item->redirect_to == "nutrition")
                  <a href="{{route('nutrition')}}">
                  @elseif($item->redirect_to == "services")
                  <a href="{{route('services')}}">
                  @elseif($item->redirect_to == "live_session")
                  <a href="{{route('live-sessions')}}">
                  @elseif($item->redirect_to == "workout_videos")
                  <a href="{{route('workout-videos')}}">
                  @else
                  <a href="#!">
                  @endif
                     <img src="{{asset($item->image)}}" alt="" class="img-fluid">
                  </a>
               </div> --}}
               <div class="col-md-6">
                     <img src="{{asset($item->image)}}" alt="" class="img-fluid">
               </div>
            </div>
         </div>
         @endforeach
      </div>
      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>
      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>
      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
   </div>
</section>
<!-- End Hero -->
<main id="main">
   <!-- ======= Services Section ======= -->
   <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">
         <div class="row">
            <div class="col-md-5 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
               <div class="icon-box iconbox-blue">
                  <h4>Mission <img src="{{asset('web/assets/img/rgt-aro.svg')}}" alt="" class="img-fluid"></h4>
                  <p>{!! $mission->value !!}</p>
               </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
               <div class="icon-box iconbox-orange ">
                  <h4>Vision <img src="{{asset('web/assets/img/rgt-aro.svg')}}" alt="" class="img-fluid"></h4>
                  <p>{!! $vision->value !!}</p>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- End Services Section -->
   <section class="p-2">
      <div class="container">
         <!-- <a href="{{route('free-trial')}}"><img src="{{asset('web/assets/img/7days-trial.png')}}" alt="" class="img-fluid"></a> -->
         <div class="row">
            <div class="col-md-4 mt-2">
               <div class="free-trial">
                  @if($userdata->is_purchase == '1' && $userdata->is_complete_freetrial == '1')
                     <a href="{{route('my-plans')}}">
                  @elseif($userdata->is_active_freetrial == '1' && $userdata->is_complete_freetrial == '0')
                     <a href="{{route('free-trial')}}">
                  @elseif($userdata->is_active_freetrial == '0' && $userdata->is_complete_freetrial == '0')
                     <a href="{{route('free-trial')}}">
                  @elseif($userdata->is_active_freetrial == '1' && $userdata->is_complete_freetrial == '1' && $userdata->is_purchase == '0')
                     <a href="{{route('free-trial')}}">
                  @endif
                     <img src="{{asset('web/assets/img/freetrial-img2.png')}}" alt="" style="height:100%;border: 3px solid gray;border-radius: 16px;" class="img-fluid">
                     <div class="free-plan">
                        @if($userdata->is_purchase == '1' && $userdata->is_complete_freetrial == '1')
                           <p>Congratulation Service Activated</p>

                           <a href="{{route('my-plans')}}">See Your Plan <i class="fa fa-arrow-right"></i></a>
                        @elseif($userdata->is_active_freetrial == '1' && $userdata->is_complete_freetrial == '0')
                           <p>Congratulation Free Trial Activated</p>
                           <p id="demo"></p>
                        @elseif($userdata->is_active_freetrial == '0' && $userdata->is_complete_freetrial == '0')
                           <p> 7 Days Free Trial  </p>
                        @elseif($userdata->is_active_freetrial == '1' && $userdata->is_complete_freetrial == '1' && $userdata->is_purchase == '0')
                           <p> Free Trial Expired  </p>
                        @endif
                        <!-- <p>Congratulation Service Activated</p>
                        <p>Congratulation Free Trial Activated</p> -->
                     </div>
                  </a>
               </div>
            </div>
            <div class="col-md-4 mt-2">
                  <a href="{{route('live-sessions')}}"><img src="{{asset('web/assets/img/sportylive.png')}}" alt="" class="img-fluid" style="width:100%;height:100%;border: 3px solid gray;border-radius: 16px;"></a>
            </div>
            <div class="col-md-4 mt-2">
                  <!-- <a href="{{route('live-sessions')}}"> -->
                     <div class="free-trial">
                        <img src="{{asset('web/assets/img/live_bg.png')}}" alt="" class="img-fluid" style="width:100%;height:100%;border: 3px solid gray;border-radius: 16px;">
                        <div class="contact-us-home">
                         <div>
                             <p>Contact Us on</p>
                           <span><a href="tel:080 69444044">080 69444044</a></span>
                         </div>

                        </div>

                     </div>
                  <!-- </a> -->
            </div>
         </div>

      </div>

   </section>
   <section id="startnow">
      <div class="container mt-5">
         <div class="tab-content">
            <div class="tab-pane fade in active" id="navtabs2">
               <div class="row mid_sec">
                  @foreach($homecategory as $key2 => $item2)
                  <div class="col-lg-3 col-md-6 portfolio-item filter-app">
                     <a href="{{route($item2->slug)}}"> <img src="{{asset($item2->image)}}" style="width:100%;border: 3px solid gray;border-radius: 45px 45px 0px 0px;height: 100%;object-fit: cover;" class="img-fluid" alt=""> </a>
                     <div class="portfolio-info">
                        <h4>{{$item2->title}}</h4>
                        <a href="{{route($item2->slug)}}"> See All <img src="{{asset('web/assets/img/blu-rght-aro.svg')}}"  class="img-fluid" alt=""></a>
                     </div>
                  </div>
                  @endforeach

                  <!-- <div class="col-lg-3 col-md-6 portfolio-item filter-app">
                     <a href="{{route('services')}}"> <img src="{{asset('web/assets/img/portfolio-10.png')}}" style="border: 3px solid gray;border-radius: 45px 45px 0px 0px;" class="img-fluid" alt=""> </a>
                     <div class="portfolio-info">
                        <h4>Packages</h4>
                        <a href="{{route('services')}}"> See All <img src="{{asset('web/assets/img/blu-rght-aro.svg')}}"  class="img-fluid" alt=""></a>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6 portfolio-item filter-web">
                     <a href="{{route('nutrition')}}">  <img src="{{asset('web/assets/img/portfolio-11.png')}}" style="border: 3px solid gray;border-radius: 45px 45px 0px 0px;" class="img-fluid" alt=""> </a>
                     <div class="portfolio-info">
                        <h4>Nutrition</h4>
                        <a href="{{route('nutrition')}}">See All <img src="{{asset('web/assets/img/blu-rght-aro.svg')}}" class="img-fluid" alt=""></a>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6 portfolio-item filter-app">
                     <a href="{{route('frc')}}">  <img src="{{asset('web/assets/img/frc-img.png')}}" style="width:100%;border: 3px solid gray;border-radius: 45px 45px 0px 0px;" class="img-fluid" alt=""> </a>
                     <div class="portfolio-info">
                        <h4>FRC</h4>
                        <a href="{{route('frc')}}">See All <img src="{{asset('web/assets/img/blu-rght-aro.svg')}}"  class="img-fluid" alt=""></a>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6 portfolio-item filter-card">
                     <a href="{{route('comming-soon')}}">  <img src="{{asset('web/assets/img/portfolio-13.png')}}" style="border: 3px solid gray;border-radius: 45px 45px 0px 0px;" class="img-fluid" alt=""> </a>
                     <div class="portfolio-info">
                        <h4>Community</h4>
                        <a href="{{route('comming-soon')}}">See All <img src="{{asset('web/assets/img/blu-rght-aro.svg')}}" class="img-fluid" alt=""></a>
                     </div>
                  </div> -->
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="">
      <div class="container">
         <div class="row app-dwnd">
            <div class="col-md-6 p-0">
               <div class="on-tch-gm">
                  {{-- <a href="#!">
                  <img src="{{asset('web/assets/img/console.svg')}}" class="img-fluid" alt=""> One Touch Game <img src="{{asset('web/assets/img/right-aro.svg')}}" class="img-fluid" alt="">
                  </a> --}}
               </div>
            </div>
            <div class="col-md-6 text-center p-5">
               <img src="{{asset('web/assets/img/logo-updated3.png')}}" class="img-fluid" alt="" style="max-width: 50%!important;">
               <h3>Download the app today</h3>
               <!-- <p>& Get 3 Month Subscription Free</p> -->
               <div class="dnwd-btn">
                  <a href="https://play.google.com/store/apps/details?id=com.sporty_life_app" target="_blank"><img src="{{asset('web/assets/img/google_play-logo.svg')}}" class="img-fluid" alt=""></a>
                  <a href="https://apps.apple.com/in/app/sporty-life/id1611151967" target="_blank"><img src="{{asset('web/assets/img/play-store-logo.svg')}}" class="img-fluid" alt=""></a>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- <div class="container newsletter news_home">
      <div class="row">
         <div class="col-md-12">
            <h3> Subscribe to our Newsletter </h3>
            <p>Signup for our weekly newsletter to get the latest news, updates and amazing offers delevered directly in your inbox.</p>
            <form role="form" method="POST" action="{{ url('newsletters') }}">
               @csrf
               <div class="input-group">
                  <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
                  <span class="input-group-btn">
                  <button class="btn" type="submit">Subscribe Now</button>
                  </span>
               </div>
            </form>
         </div>
      </div>
   </div> -->
</main>
<!-- End #main -->
@endsection
@section('script')
<script>
var countDownDate = new Date('<?php echo date("M d, Y H:i:s", strtotime($userdata->freetrial_duration)); ?>').getTime();
// var countDownDate = new Date("Jan 5, 2023 15:37:25").getTime();
var x = setInterval(function() {
  var now = new Date().getTime();
  var distance = countDownDate - now;
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
   var is_active_freetrial = <?php echo $userdata->is_active_freetrial; ?>;
   var is_complete_freetrial = <?php echo $userdata->is_complete_freetrial; ?>;
   if (is_active_freetrial == '1' && is_complete_freetrial == '0') {
      // Output the result in an element with id="demo"
      document.getElementById("demo").innerHTML = days + "d " + hours + "h "
      + minutes + "m " + seconds + "s ";

      // If the count down is over, write some text
      if (distance < 0) {
        clearInterval(x);
       //  document.getElementById("demo").innerHTML = "EXPIRED";
      }
   }
}, 1000);
</script>
<script>
   // function newsletters() {
   //    var email = $("#email").val();
   //    $.ajax({
   //         url: "{{url('newsletters')}}",
   //         type: 'post',
   //         dataType: 'json',
   //         data: {
   //            'email':email
   //         },
   //         headers: {
   //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //         },
   //         success: function(data){
   //             if (data.statusCode == "200") {
   //                toastr.success(data.message);
   //                location.reload(true);
   //             }else{
   //                toastr.error(data.message);
   //             }
   //          },
   //          error: function(){

   //          }
   //     });
   // }
</script>
@endsection