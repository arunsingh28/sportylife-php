@extends('layouts.main')
@section('style')
<style>
    .body-vec:after {
        content: '';
        background: none !important;
    }
</style>
@endsection
@section('content')
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
                                            <span>{{$user->name}}</span>
                                        </li>
                                        <li>
                                            <p>Gender:</p>
                                            <a style="color:white;" href="{{url('profile-edit/frc')}}">
                                            <span>{{ucfirst($user->gender)}}</span>
                                            <span><i class="fa fa-pencil" style="font-size: 15px;"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <p>Age:</p>
                                            <a style="color:white;" href="{{url('profile-edit/frc')}}">
                                            <span>{{$user->age}}</span>
                                            <span><i class="fa fa-pencil" style="font-size: 15px;"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <p>Height:</p>
                                            <a style="color:white;" href="{{url('profile-edit/frc')}}">
                                            @if($user->height_type == "Inch")
                                            <span>{{$user->height_feet}}.{{$user->height_inch ?? '0'}}'</span>
                                            @else
                                            <span>{{$user->height_feet}} {{$user->height_inch ?? '0'}}"</span>
                                            @endif
                                            <span><i class="fa fa-pencil" style="font-size: 15px;"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <p>weight:</p>
                                            <a style="color:white;" href="{{url('profile-edit/frc')}}">
                                            <span>{{$user->weight}} {{$user->weight_type}}</span>
                                            <span><i class="fa fa-pencil" style="font-size: 15px;"></i></span>
                                            </a>
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
                                    <!-- <span style="font-size:22px;">{{$user->bmi_range}}</span> -->
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="frc-h3">BMI Range</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
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
                                    <span style="font-size: 12px;color: transparent;border-radius: 8px;background: linear-gradient(260deg, rgba(9,183,9) 0%, rgba(32,135,32) 49%, rgba(9,110,9) 100%) !important;padding: 11px;float: right;">18</span>
                                </div>
                                <div class="col-md-9" style="margin-top: 0.3rem!important;">
                                    <h4 class="frc-h3" style="font-size: 17px;text-align: left;margin-top: -6px !important;">Normal weight<br>(18.5 - 24.9)</h4>
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
                                    <span style="font-size: 12px;color: transparent;border-radius: 8px;background: linear-gradient(260deg, rgba(231,182,191) 0%, rgba(187,122,134) 49%, rgba(159,117,124) 100%) !important;padding: 11px;float: right;">35</span>
                                </div>
                                <div class="col-md-9" style="margin-top: 0.3rem!important;">
                                    <h4 class="frc-h3" style="font-size: 17px;text-align: left;margin-top: -6px !important;">Obesity class II  <br>(35.0 - 39.9)</h4>
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
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="frc-h3">Body Composition Referal</h3>
                </div>
            </div>
            <div class="row ref_body">
                <div class="col-md-12 text-center">
                    <div class="body-vec">
                        @if($user->gender == "male")
                            @if($user->age < "18")
                            <img style="height: 440px;" src="{{asset('uploads/frc-kid-boy-white.png')}}" alt="" class="img-fluid">
                            @else
                            <img style="height: 440px;" src="{{asset('uploads/frc-adult-man-white.png')}}" alt="" class="img-fluid">
                            @endif
                        @elseif($user->gender == "female")
                            @if($user->age < "18")
                            <img style="height: 440px;" src="{{asset('uploads/frc-kid-girl-white.png')}}" alt="" class="img-fluid">
                            @else
                            <img style="height: 440px;" src="{{asset('uploads/frc-adult-woman-white.png')}}" alt="" class="img-fluid">
                            @endif
                        @else
                        <img style="height: 440px;" src="{{asset('uploads/frc-adult-man-white.png')}}" alt="" class="img-fluid">
                        @endif

                    </div>
                </div>
            </div>
            <!-- <div class="mt-5" style="border: 0.5px solid lightgrey;border-radius: 18px;"> -->
                
            <!-- </div> -->
        </div>
    </section>
</main>
@endsection
@section('script')
@endsection