<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Sporty Life</title>
      <meta content="" name="description">
      <meta content="" name="keywords">
      <style>
         .row {
         --bs-gutter-x: 1.5rem;
         --bs-gutter-y: 0;
         display: flex;
         flex-wrap: wrap;
         margin-top: calc(-1 * var(--bs-gutter-y));
         margin-right: calc(-.5 * var(--bs-gutter-x));
         margin-left: calc(-.5 * var(--bs-gutter-x));
         }
         body {
         font-family: 'Nunito', sans-serif;
         color: #4d4643;
         background: rgb(33,33,33);
         background: linear-gradient(
         -70deg, rgba(33,33,33,1) 0%, rgba(0,0,0,1) 100%);
         }
         @media (min-width: 768px){
             .col-md-1 {
             flex: 0 0 auto;
             width: 8.33333333%;
             }
             .col-md-10 {
             flex: 0 0 auto;
             width: 83.33333333%;
             }
             .col-lg-5 {
             flex: 0 0 auto;
             width: 41.66666667%;
             }
             .col-lg-7 {
             flex: 0 0 auto;
             width: 58.33333333%;
             }

         }
         @media (min-width: 1200px){
             .container, .container-lg, .container-md, .container-sm, .container-xl {
             max-width: 1140px;
             }

         }
         
         .frc {
         /* width: 90%; */
         margin-top: 60px;
         background: rgb(2,192,240);
         background: linear-gradient(
         260deg, rgba(2,192,240,1) 0%, rgba(88,119,234,1) 49%, rgba(190,33,227,1) 100%);
         border-radius: 50px;
         text-align: center;
         }
         .frc-lft {
         background: rgba(255, 255, 255, 0.1);
         border-radius: 50px 0px 0px 50px;
         padding: 35px 20px;
         }
         .frc-lft ul {
         list-style: none;
         margin: 0;
         }
         .frc-lft ul li {
         color: #fff;
         font-size: 15px;
         text-align: left;
         }
         ol, ul {
         padding-left: 2rem;
         }
         .frc-lft ul li span {
         display: inline-block;
         font-weight: 700;
         text-decoration: underline;
         }
         .frc-lft ul li p {
         width: 40%;
         display: inline-block;
         }
         .frc-rgt {
         background: url('https://stage.tasksplan.com/sportylife/public/web/assets/img/dotted-bg.svg') no-repeat;
         font-size: 35px;
         background-position: center;
         line-height: 47px;
         color: #fff;
         margin-top: 35px;
         font-weight: 700;
         min-height: 290px;
         padding-top: 20px;
         /* margin-left: 27%; */
         }
         .frc-h3 {
         font-size: 25px;
         color: #212121;
         font-weight: 600;
         text-align: center;
         margin: 40px 0px;
         }
         .body-lvl {
         display: inline-block;
         vertical-align: bottom;
         color: #212121;
         }
         .body-lvl p {
         font-size: 17px;
         margin-top: 20px;
         line-height: 21px;
         font-weight: 700;
         }
         .body-vec {
         display: inline-block;
         vertical-align: top;
         position: relative;
         margin-right: 30px;
         }
         .body-vec:after {
         content: 'Male';
         display: block;
         background: #fff;
         color: #000;
         padding: 5px 15px;
         border-radius: 30px;
         position: absolute;
         font-size: 13px;
         border: 0;
         left: 22px;
         /* z-index: 9999; */
         width: 75px;
         height: 28px;
         bottom: -40px;
         text-align: center;
         font-weight: 700;
         }
         .body-vec1 {
         position: relative;
         margin-right: 0px;
         margin-left: 30px;
         }
         .body-vec:after {
         content: 'Male';
         display: block;
         background: #fff;
         color: #000;
         padding: 5px 15px;
         border-radius: 30px;
         position: absolute;
         font-size: 13px;
         border: 0;
         left: 15px;
         /* z-index: 9999; */
         width: 82px;
         height: 37px;
         bottom: -39px;
         text-align: center;
         font-weight: 700;
         }
         .body-vec1:after {
         content: 'Female';
         }
         .text-end {
         text-align: right!important;
         }
         .text-right {
         text-align: right !important;
         }
         .frc-h3 {
            margin: 9px 20px !important;
        }
      </style>
   </head>
   <body>
      <main id="main">
         <section>
            <div class="container">
               <div class="row">
                  <div class="col-md-1"></div>
                 <div class="col-md-10">
                            @if($user->frc_color == "blue")
                            <div class="frc" style="background: linear-gradient(260deg, rgba(2,192,240,1) 0%, rgba(88,119,234,1) 49%, rgba(190,33,227,1) 100%) !important;">
                            @elseif($user->frc_color == "green")
                            <div class="frc" style="background: linear-gradient(260deg, rgba(9,183,9) 0%, rgba(32,135,32) 49%, rgba(9,110,9) 100%) !important;">
                            @elseif($user->frc_color == "yellow")
                            <div class="frc" style="background: linear-gradient(260deg, rgba(255,206,0,1) 0%, rgba(217,161,8,1) 49%, rgba(255,187,0,1) 100%) !important;">
                            @elseif($user->frc_color == "orange")
                            <div class="frc" style="background: linear-gradient(260deg, rgba(239,103,52,1) 0%, rgba(239,103,52,1) 49%, rgba(239,70,52,1) 100%) !important;">
                            @elseif($user->frc_color == "pink")
                            <div class="frc" style="background: linear-gradient(260deg, rgba(231,182,191) 0%, rgba(187,122,134) 49%, rgba(159,117,124) 100%) !important;">
                            @elseif($user->frc_color == "red")
                            <div class="frc" style="background: linear-gradient(260deg, rgba(225,31,31) 0%, rgba(199,39,39) 49%, rgba(221,15,15) 100%) !important;">
                            @else
                            <div class="frc" style="background: linear-gradient(260deg, rgba(2,192,240,1) 0%, rgba(88,119,234,1) 49%, rgba(190,33,227,1) 100%) !important;">
                            @endif
                                <div class="row">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="frc-lft">
                                            <ul>
                                                <li>
                                                    <p>Name:</p>
                                                    <span>{{$user->first_name}}</span>
                                                </li>
                                                <!-- <li>
                                                    <p>Gender:</p>
                                                    <span>{{ucfirst($user->gender)}}</span>
                                                </li> -->
                                                <li>
                                                    <p>Age:</p>
                                                    <span>{{$user->age}} Years</span>
                                                </li>
                                                <li>
                                                    <p>Height:</p>
                                                     @if($user->height_type == "Inch")
                                                    <span>{{$user->height_feet}}.{{$user->height_inch ?? '0'}}'</span>
                                                    @else
                                                    <span>{{$user->height_feet}}.{{$user->height_inch ?? '0'}} cm</span>
                                                    @endif
                                                </li>
                                                <li>
                                                    <p>weight:</p>
                                                    <span>{{$user->weight}} {{$user->weight_type}}</span>
                                                </li>
                                                <li>
                                                    <p>IBW:</p>
                                                    <span>{{$user->ibw}} kg</span>
                                                </li>
                                                <li>
                                                    <p>BMI:</p>
                                                    <span>{{$user->bmi}} kg/m2</span>
                                                </li>
                                                <li>
                                                    <p>BMI Range:</p>
                                                    <span>{{$user->bmi_range}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6">
                                        <div class="frc-rgt">
                                            Age BMI<br>
                                            Estimator: <br>
                                            {{$user->frc_category}} <br>
                                            {{$user->bmi}} kg/m2 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                  <div class="col-md-1"></div>
               </div>
                <div class="row mt-5" style="margin-left: 37% !important;">
                    <div class="col-md-12" style="text-align: center;">
                        <h3 class="frc-h3">BMI Range</h3>
                    </div>
                </div>
                <div class="row" style="margin-left: 20% !important;">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right;">
                                        <span style="font-size: 12px;color: transparent;border-radius: 8px;background:linear-gradient(260deg, rgba(2,192,240,1) 0%, rgba(88,119,234,1) 49%, rgba(190,33,227,1) 100%) !important;padding: 11px;float: right;">18</span>
                                    </div>
                                    <div class="col-md-9" style="margin-top: 0.3rem!important;">
                                        <h4 class="frc-h3" style="font-size: 17px;text-align: left;margin-top: -6px !important;">Underweight <br>(Below 18.5)</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right;">
                                        <span style="font-size: 12px;color: transparent;border-radius: 8px;background: linear-gradient(260deg, rgba(239,103,52,1) 0%, rgba(239,103,52,1) 49%, rgba(239,70,52,1) 100%) !important;padding: 11px;float: right;">30</span>
                                    </div>
                                    <div class="col-md-9" style="margin-top: 0.3rem!important;">
                                        <h4 class="frc-h3" style="font-size: 17px;text-align: left;margin-top: -6px !important;">Obesity class I <br>(30.0 - 34.9)</h4>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right;">
                                        <span style="font-size: 12px;color: transparent;border-radius: 8px;background: linear-gradient(260deg, rgba(9,183,9) 0%, rgba(32,135,32) 49%, rgba(9,110,9) 100%) !important;padding: 11px;float: right;">18</span>
                                    </div>
                                    <div class="col-md-9" style="margin-top: 0.3rem!important;">
                                        <h4 class="frc-h3" style="font-size: 17px;text-align: left;margin-top: -6px !important;">Normal weight<br>(18.5 - 24.9)</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right;">
                                        <span style="font-size: 12px;color: transparent;border-radius: 8px;background: linear-gradient(260deg, rgba(231,182,191) 0%, rgba(187,122,134) 49%, rgba(159,117,124) 100%) !important;padding: 11px;float: right;">35</span>
                                    </div>
                                    <div class="col-md-9" style="margin-top: 0.3rem!important;">
                                        <h4 class="frc-h3" style="font-size: 17px;text-align: left;margin-top: -6px !important;">Obesity class II  <br>(35.0 - 39.9)</h4>
                                    </div>
                                </div>
                                
                                
                                
                                
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right;">
                                        <span style="font-size: 12px;color: transparent;border-radius: 8px;background: linear-gradient(260deg, rgba(255,206,0,1) 0%, rgba(217,161,8,1) 49%, rgba(255,187,0,1) 100%) !important;padding: 11px;float: right;">25</span>
                                    </div>
                                    <div class="col-md-9" style="margin-top: 0.3rem!important;">
                                        <h4 class="frc-h3" style="font-size: 17px;text-align: left;margin-top: -6px !important;">Overweight <br>(25.0 - 29.9)</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right;">
                                        <span style="font-size: 12px;color: transparent;border-radius: 8px;background: linear-gradient(260deg, rgba(225,31,31) 0%, rgba(199,39,39) 49%, rgba(221,15,15) 100%) !important;padding: 11px;float: right;">40</span>
                                    </div>
                                    <div class="col-md-9" style="margin-top: 0.3rem!important;">
                                        <h4 class="frc-h3" style="font-size: 17px;text-align: left;margin-top: -6px !important;">Obesity class III  <br>(Above 40)</h4>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
         </section>
      </main>
      <!-- End #main -->
   </body>
</html>