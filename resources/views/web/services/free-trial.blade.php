@extends('layouts.main')
@section('style')
<style>
  
   @media screen and (min-width: 1024px) {
   .workouttext {
        margin: 0px 0px 75px 23px !important;
   }
   }
   @media screen and (min-width: 1399px) {
   .workouttext {
        margin: 0px 0px 89px 23px !important;
   }
   }
</style>
@endsection
@section('content')
<div class="free_trial">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-0">
            </div>
            <div class="col-lg-8 col-md-12">
            <form role="form" method="POST" action="{{ url('startFreeTrial') }}">
                        @csrf
                <h2>7 Day free trial</h2>
                <div class="trail_sec">
                    
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="start_pages" style="border-right: 0px solid #30323E !important;">
                                <img src="{{asset('web/assets/img/start_up.png')}}">
                                <h5>{{$packagedata->title}} <br> <img src="{{asset('web/assets/img/rs.svg')}}"> {{$packagedata->price}} <span style="font-size: 22px;font-weight: 400;"> / {{$packagedata->duration_type}}</span></h5>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="consultation" style="border-left: 1px solid #30323E;">
                                <a class="secure-payment" href="#!"> {{$packagedata->package_tag}} </a>
                                <ul>
                                    @foreach($packagedata->description as $key => $item)
                                    <li><a href="#!"> <img src="{{asset('web/assets/img/meeting-point.svg')}}"> &nbsp;&nbsp;&nbsp; {{$item}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-12 mt-4 mb-0" style="text-align:center;">
                    @if($user->is_active_freetrial == "1")
                        <input type="button" class="btn-send" style="background: #F6EE00 !important;color: #212121 !important;" value="Activated">
                    @elseif($user->is_complete_freetrial == "1")
                        <input type="button" class="btn-send btn-success" style="background: #16e183 !important;color: #212121 !important;"  value="Completed">
                    @else
                        <input type="submit" class="btn-send" value="Try Now">
                    @endif
                </div> -->
                @if($user->is_active_freetrial == "1" || $user->is_complete_freetrial == "1")
                    <div class="row mt-5">
                        <div class="col-md-4 mt-3">
                            <a href="{{route('live-sessions')}}"><img src="{{asset('web/assets/img/sportylive.png')}}" style="width: -webkit-fill-available;"></a>
                        </div>
                        <div class="col-md-4 mt-3">
                            <a href="{{route('web.sports-curriculum')}}"><img src="{{asset('web/assets/img/sports-curriculum.png')}}" style="width: -webkit-fill-available;"></a>
                        </div>
                        <div class="col-md-4 mt-3">
                            <a href="{{route('workout-videos')}}"><img src="{{asset('web/assets/img/work-out1.png')}}" style="width: -webkit-fill-available;"></a>
                        </div>
                        
                    </div>
                    <div class="row mt-5">
                        
                        <!-- <div class="col-lg-12 col-md-6 portfolio-item1 " style="text-align: center;">
                            <a href="{{route('workout-videos')}}" >
                            <img src="{{asset('web/assets/img/work-out1.png')}}" style="width: 49%!important;height: 57%!important;object-fit: cover;border-radius: 13px !important;" class="img-fluid" alt="">
                            <div class="sess-time workouttext" style="width: 93.7% !important;text-align: center !important;border-radius: 0px !important;background: transparent !important;">
                                <p style="font-weight: 800 !important;color: black !important;font-size: 25px !important;">Workout Videos</p>
                            </div>
                            </a>
                        </div> -->
                    </div>
                @else
                    <input type="submit" class="btn-send" value="Try Now">
                @endif
            </form>
            </div>
            <div class="col-lg-2 col-md-0">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection