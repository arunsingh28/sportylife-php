@extends('layouts.main')
@section('style')
<style>
   @media screen and (max-width: 767px) {
      .water-indicator p {
         text-align: left !important;
         margin-left: 10px;
      }

      .water-indicator {
         bottom: 0 !important;
         z-index: 9999;
      }

      .progress {
         width: 230px !important;
         height: 230px !important;
      }

      .progress-value p {
         font-size: 36px;
         line-height: 30px;
      }

      .progress .progress-value span {
         font-size: 25px;
         margin: 10px 0;
      }

      .progress {
         margin: 20px auto 0;
      }
   }

   @media screen and (max-width: 992px) {
      .progress {
         width: 100px;
         height: 100px;
      }

      .progress .progress-value {
         width: 20%;
         height: 100%;
         font-size: 35px;
         position: relative;
         margin: auto;
      }

      .progress:after {
         border: 7px solid #efefef;
      }
   }

   @media screen and (max-width: 758px) {
      .man-water {
         border-radius: 10px;
         overflow: hidden;
         border: 5px solid #fff;
         left: 0;
         margin: 0 20px;
      }
   }

   @media screen and (max-width: 575px) {
      .nutrition {
         padding: 40px 20px;
      }

      .man-water {
         border-radius: 10px;
         overflow: hidden;
         border: 5px solid #fff;
         left: 0;
         margin: 0 20px;
         height: 310px !important;
      }

      .nutrition .glas-wtr a {
         width: 10%;
      }

      .nutrition .glas-wtr img {
         max-width: 100%;
         margin: 16px 0 !important;
      }
   }

   @media screen and (max-width: 340px) {
      .bowl {
         left: -60px !important;
      }
   }

   @media screen and (max-width: 340px) {
      .bowl {
         left: -60px !important;
      }

      .nutrition .hmn-body {
         margin-left: -60px !important;
      }
   }

   .bowl {
      position: absolute !important;
      width: 250px;
      height: 300px;
      left: 2px;
      top: 0;
      margin: 0 !important;
   }

   /* today */
   @media screen and (min-width: 768px) {
      .bowl {
         position: relative;
         width: 250px;
         height: 300px;
         /* margin: 20px; */
         margin: -300px 0px 0px 10px;
      }
   }

   @media screen and (min-width: 1024px) {
      .bowl {
         position: relative;
         width: 376px;
         height: 300px;
         /* margin: 20px; */
         margin: -300px 0px 0px 10px;
      }
   }

   @media screen and (min-width: 1399px) {
      .bowl {
         position: relative;
         width: 396px;
         height: 300px;
         /* margin: 20px; */
         margin: -300px 0px 0px 48px;
      }
   }

   .bowl:before {
      overflow: hidden;
      content: "";
      background: url("public/uploads/exclusion1.png") no-repeat;
      position: absolute;
      width: 246px;
      height: 300px;
      z-index: 2;
      left: 0;
      top: 0;
   }

   .bowl .inner {
      width: 160px;
      height: 300px;
      overflow: hidden;
      -webkit-backface-visibility: hidden;
      -webkit-transform: translate3d(0, 0, 0);
      margin: 0 auto;
      position: absolute;
      bottom: 0;
      left: 40px;
   }

   .bowl .fill {
      -webkit-animation-name: fillAction;
      -webkit-animation-iteration-count: 1;
      /* -webkit-animation-timing-function: cubic-bezier(0.2, 0.6, 0.8, 0.4);
   -webkit-animation-duration: 4s; */
      -webkit-animation-fill-mode: forwards;
   }

   .bowl .waveShape {
      -webkit-animation-name: waveAction;
      -webkit-animation-iteration-count: infinite;
      -webkit-animation-timing-function: linear;
      -webkit-animation-duration: 0.5s;
      width: 300px;
      height: 150px;
      fill: #039be4;
   }

   @-webkit-keyframes fillAction {
      0% {
         -webkit-transform: translate(0, 300px);
      }

      100% {
         -webkit-transform: translate(0, <?php echo (@$today_waterlevel ?? '0') . "px"; ?>);
      }
   }

   @-webkit-keyframes waveAction {
      0% {
         -webkit-transform: translate(-150px, 0);
      }

      100% {
         -webkit-transform: translate(0, 0);
      }
   }

   @media screen and (min-width: 768px) {
      /* .bowl1 {
   position: relative;
   width: 250px;
   height: 300px;
   margin: -300px 0px 0px 10px; 
   } */
   }

   /* yesterday */
   @media screen and (min-width: 1024px) {
      /* .bowl1 {
   position: relative;
   width: 376px;
   height: 300px;
   margin: -300px 0px 0px 10px;
   } */
   }

   .bowl1 {
      position: absolute;
      width: 396px;
      height: 300px;
      left: 3px;
      margin: 0 !important;
      top: 0;
   }

   @media screen and (min-width: 1399px) {}

   .bowl1:before {
      overflow: hidden;
      content: "";
      background: url("public/uploads/exclusion1.png") no-repeat;
      position: absolute;
      width: 246px;
      height: 300px;
      z-index: 2;
      left: 0;
      top: 0;
   }

   .bowl1 .inner {
      width: 160px;
      height: 300px;
      overflow: hidden;
      -webkit-backface-visibility: hidden;
      -webkit-transform: translate3d(0, 0, 0);
      margin: 0 auto;
      position: absolute;
      bottom: 0;
      left: 30px;
   }

   .bowl1 .fill {
      -webkit-animation-name: fillAction1;
      -webkit-animation-iteration-count: 1;
      /* -webkit-animation-timing-function: cubic-bezier(0.2, 0.6, 0.8, 0.4);
   -webkit-animation-duration: 4s; */
      -webkit-animation-fill-mode: forwards;
   }

   .bowl1 .waveShape {
      -webkit-animation-name: waveAction1;
      -webkit-animation-iteration-count: infinite;
      -webkit-animation-timing-function: linear;
      -webkit-animation-duration: 0.5s;
      width: 300px;
      height: 150px;
      fill: #039be4;
   }

   @-webkit-keyframes fillAction1 {
      0% {
         -webkit-transform: translate(0, 300px);
      }

      100% {
         -webkit-transform: translate(0, <?php echo (@$yesterday_waterlevel ?? '0') . "px"; ?>);
      }
   }

   @-webkit-keyframes waveAction1 {
      0% {
         -webkit-transform: translate(-150px, 0);
      }

      100% {
         -webkit-transform: translate(0, 0);
      }
   }

   .nutrition {
      background: linear-gradient(180deg, rgba(2, 192, 240, 1) 0%, rgba(88, 119, 234, 1) 49%, rgba(190, 33, 227, 1) 100%) !important;
   }

   .gm-count {
      font-size: 18px !important;
   }

   .water-indicator {
      position: absolute;
      bottom: -45px;
      width: 100%;
      left: 0;
   }

   .water-indicator p {
      text-align: center;
   }

   @media screen and (max-width: 412px) and (min-width: 340px) {
      .man-water .hmn-body {
         position: relative;
         left: -41px;
      }

      .bowl {
         left: -39px;
      }

      .bowl1 {
         left: -39px;
      }
   }
</style>
@endsection
@section('content')
<main id="main">
   <section>
      <div class="container">
         @if(!empty($user_data->weight) && !empty($user_data->height_feet))
         <div class="row">
            <!-- <div class="col-md-1"></div> -->
            <div class="col-lg-12 col-md-12">
               <div class="nutrition">
                  <ul class="nav nav-tabs" id="myNavTabs">
                     <li><a class="active" href="#navtabs1" data-toggle="tab">Today</a></li>
                     <li><a href="#navtabs2" data-toggle="tab">Yesterday</a></li>
                  </ul>
                  <div class="tab-content">
                     <div class="tab-pane fade in active" id="navtabs1">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="meeter" style="display: flex; position: relative;">
                                 <div class="glas-wtr" style="z-index: 10;position: relative;">
                                    @if(!empty($todaywaterleveldata))
                                    @if($todaywaterleveldata->water_level >= 16)
                                    <a href="#!"><img src="{{asset('web/assets/img/plus.svg')}}" onclick="alert('Today water limit is complete.')" alt="" class="img-fluid"></a>
                                    @else
                                    <a href="{{url('userWaterLevel/add')}}"><img src="{{asset('web/assets/img/plus.svg')}}" alt="" class="img-fluid"></a>
                                    @endif
                                    @else
                                    <a href="{{url('userWaterLevel/add')}}"><img src="{{asset('web/assets/img/plus.svg')}}" alt="" class="img-fluid"></a>
                                    @endif
                                    <img class="m-3" src="{{asset('web/assets/img/glass-of-water.svg')}}" alt="" class="img-fluid">
                                    <p style="color:white;">250 ML</p>

                                    @if(!empty($todaywaterleveldata))
                                    @if($todaywaterleveldata->water_level <= 0) <a href="#!"><img src="{{asset('web/assets/img/minus.svg')}}" onclick="alert('You can not decrease more!')" alt="" class="img-fluid"></a>
                                       @else
                                       <a href="{{url('userWaterLevel/minus')}}"><img src="{{asset('web/assets/img/minus.svg')}}" alt="" class="img-fluid"></a>
                                       @endif
                                       @else
                                       <a href="#!"><img src="{{asset('web/assets/img/minus.svg')}}" alt="" class="img-fluid"></a>
                                       @endif
                                 </div>
                                 <div class="man-water" style="position: relative;">
                                    <img class="hmn-body" style="width: 250px;height: 300px;" src="{{asset('uploads/exclusion2.png')}}" alt="" class="img-fluid">
                                    <div class="bowl">
                                       <div class="inner">
                                          <div class="fill">
                                             <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="300px" height="300px" viewBox="0 0 300 300" enable-background="new 0 0 300 300" xml:space="preserve">
                                                <path class="waveShape" d="M300,300V2.5c0,0-0.6-0.1-1.1-0.1c0,0-25.5-2.3-40.5-2.4c-15,0-40.6,2.4-40.6,2.4
                                                   c-12.3,1.1-30.3,1.8-31.9,1.9c-2-0.1-19.7-0.8-32-1.9c0,0-25.8-2.3-40.8-2.4c-15,0-40.8,2.4-40.8,2.4c-12.3,1.1-30.4,1.8-32,1.9
                                                   c-2-0.1-20-0.8-32.2-1.9c0,0-3.1-0.3-8.1-0.7V300H300z" />
                                             </svg>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="water-indicator">
                                       <p class="mt-1" style="color:white;">{{$t_waterlevel}} Ltr</p>
                                    </div>
                                 </div>
                                 <div class="meeter-img">
                                    <img class="hmn-body" src="{{asset('web/assets/img/levelmeter.png')}}" alt="" class="img-fluid">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <?php
                              $todaycal = $nutrition_details['today']['calorie'];
                              $todaydataper = floor(($todaycal / 10000) * 100);
                              ?>
                              <div class="progress" data-percentage="{{$todaydataper}}">
                                 <span class="progress-left">
                                    <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                    <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">
                                    <!-- <img src="{{asset('web/assets/img/burn.svg')}}" alt="" class="img-fluid"> -->
                                    <p><span>KCAL</span>
                                       {{$nutrition_details['today']['calorie']}}<span> Taken</span>
                                    </p>
                                 </div>
                              </div>
                              <div class="hgt-wgt">
                                 @if($user_data->height_type == "Inch")
                                 <span>{{$user_data->height_feet}}.{{$user_data->height_inch ?? '0'}}'</span>
                                 @else
                                 <span>{{$user_data->height_feet}}.{{$user_data->height_inch ?? '0'}} cm</span>
                                 @endif
                                 {{$user_data->weight}}
                                 @if($user_data->weight_type == "Kilogram")
                                 Kg
                                 @else
                                 {{$user_data->weight_type}}
                                 @endif
                              </div>
                           </div>
                           <div class="col-md-2 text-center">
                              <div class="gm-count">{{$nutrition_details['today']['carbs']}}<br><span class="ft15">Carbs</span></div>
                              <div class="gm-count gm-white">{{$nutrition_details['today']['protein']}}<br><span class="ft15">Protein</span></div>
                              <div class="gm-count gm-ble">{{$nutrition_details['today']['fats']}}<br><span class="ft15">Fats</span></div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="navtabs2">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="meeter" style="display: flex; position: relative;">
                                 <div class="glas-wtr" style="z-index: 10;position: relative;">
                                    <img src="{{asset('web/assets/img/plus.svg')}}" alt="" class="img-fluid">
                                    <img class="m-3" src="{{asset('web/assets/img/glass-of-water.svg')}}" alt="" class="img-fluid">
                                    <p style="color:white;">250 ML</p>
                                    <img src="{{asset('web/assets/img/minus.svg')}}" alt="" class="img-fluid">
                                 </div>
                                 <div class="man-water" style="position: relative;">
                                    <img class="hmn-body" style="width: 250px;height: 300px;" src="{{asset('uploads/exclusion2.png')}}" class="img-fluid">
                                    <div class="bowl1 ">
                                       <div class="inner">
                                          <div class="fill">
                                             <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="300px" height="300px" viewBox="0 0 300 300" enable-background="new 0 0 300 300" xml:space="preserve">
                                                <path class="waveShape" d="M300,300V2.5c0,0-0.6-0.1-1.1-0.1c0,0-25.5-2.3-40.5-2.4c-15,0-40.6,2.4-40.6,2.4
                                                   c-12.3,1.1-30.3,1.8-31.9,1.9c-2-0.1-19.7-0.8-32-1.9c0,0-25.8-2.3-40.8-2.4c-15,0-40.8,2.4-40.8,2.4c-12.3,1.1-30.4,1.8-32,1.9
                                                   c-2-0.1-20-0.8-32.2-1.9c0,0-3.1-0.3-8.1-0.7V300H300z" />
                                             </svg>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="water-indicator">
                                       <p class="mt-1" style="color:white;">{{$y_waterlevel}} Ltr</p>
                                    </div>
                                 </div>
                                 <div class="meeter-img">
                                    <img class="hmn-body" src="{{asset('web/assets/img/levelmeter.png')}}" alt="" class="img-fluid">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <?php
                              $ycal = $nutrition_details['yesterday']['calorie'];
                              $ydataper = floor(($ycal / 10000) * 100);
                              ?>
                              <div class="progress" data-percentage="{{$ydataper}}">
                                 <span class="progress-left">
                                    <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                    <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">
                                    <div>
                                       <!-- <img src="{{asset('web/assets/img/burn.svg')}}" alt="" class="img-fluid"><br> -->
                                       <p><span>KCAL</span> {{$nutrition_details['yesterday']['calorie']}}<span> Taken</span></p>
                                    </div>
                                 </div>
                              </div>
                              <div class="hgt-wgt">
                                 <!-- <span>{{$user_data->height_feet}}.{{$user_data->height_inch}}' Height</span>
                                    {{$user_data->weight}} Kg -->
                                 @if($user_data->height_type == "Inch")
                                 <span>{{$user_data->height_feet}}.{{$user_data->height_inch ?? '0'}}'</span>
                                 @else
                                 <span>{{$user_data->height_feet}}.{{$user_data->height_inch ?? '0'}} cm</span>
                                 @endif
                                 <!-- <span>{{$user_data->height_feet}}.{{$user_data->height_inch}}' Height</span> -->
                                 {{$user_data->weight}}
                                 @if($user_data->weight_type == "Kilogram")
                                 Kg
                                 @else
                                 {{$user_data->weight_type}}
                                 @endif
                              </div>
                           </div>
                           <div class="col-md-2 text-center">
                              <div class="gm-count">{{$nutrition_details['yesterday']['carbs']}}<br><span class="ft15">Carbs</span></div>
                              <div class="gm-count gm-white">{{$nutrition_details['yesterday']['protein']}}<br><span class="ft15">Protein</span></div>
                              <div class="gm-count gm-ble">{{$nutrition_details['yesterday']['fats']}}<br><span class="ft15">Fats</span></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- <div class="col-md-1"></div> -->
         </div>
         <div class="nutri-qte">
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <div id="carouselExample" class="carousel slide w-100" data-bs-ride="carousel" data-bs-interval="3000">
                     <div class="carousel-inner">
                        @foreach($nutrition_quotes as $key => $item)
                        <div class="carousel-item <?php if ($key == "0") {
                                                      echo "active";
                                                   }  ?>">
                           <p>{{$item->title}}</p>
                        </div>
                        @endforeach
                     </div>
                     <div class="carousel-indicators">
                        @foreach($nutrition_quotes as $key => $item)
                        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="{{$key}}" class="<?php if ($key == "0") {
                                                                                                                        echo "active";
                                                                                                                     }  ?>"></button>
                        @endforeach
                     </div>
                  </div>
               </div>
               <div class="col-md-2"></div>
            </div>
         </div>
         <div class="row mt-5 lip_portal">
            <div class="col-lg-2 col-md-0"></div>
            <div class="col-lg-3 col-md-3 text-end">
               <a href="{{route('recipes')}}" class="rec-nut">
                  <img src="{{asset('web/assets/img/recipe-book.svg')}}" alt="" class="img-fluid">
                  Recipes
               </a>
            </div>
            <div class="col-lg-2 col-md-3 text-center">
               <a href="{{route('web-nutrition-blogs')}}" class="rec-nut">
                  <img src="{{asset('web/assets/img/nutrition.svg')}}" alt="" class="img-fluid">
                  Nutrition Blogs
               </a>
            </div>
            <div class="col-lg-2 col-md-3 text-center">
               <a href="{{route('diary')}}" class="rec-nut">
                  <img src="{{asset('web/assets/img/notebook.svg')}}" alt="" class="img-fluid">
                  Diary
               </a>
            </div>
            <div class="col-lg-2 col-md-3  text-right">
               {{-- <a href="#!" class="rec-nut on-tch">
               <img src="{{asset('web/assets/img/console.svg')}}" alt="" class="img-fluid">
               One Touch Game
               </a> --}}
            </div>
            <div class="col-lg-2 col-md-0"></div>
         </div>
         @else
         <div class="row" >
         <div class="col-lg-1 col-md-12"></div>
         <div class="col-lg-10 col-md-12" style="background: linear-gradient(260deg, rgba(2,192,240,1) 0%, rgba(88,119,234,1) 49%, rgba(190,33,227,1) 100%) !important; border-radius:70px; margin-top: 60px;text-align: center;">
           
               <div class="frc-rgt"  >
                  Please complete your profile to access the requested details.
                  <a style="color:white;" href="{{url('profile-edit/profile')}}"> <button class="btn btn-info">Edit Now</button>
                  </a>

               </div>
              
            </div>
            <div class="col-lg-1 col-md-12"></div>
         </div>
         @endif
      </div>
   </section>
</main>
@endsection
@section('script')
<script>
   $(document).ready(function() {
      element.setAttribute('style', 'transform:rotate(90deg); -webkit-transform: rotate(90deg)') //etc
   });
</script>
@endsection