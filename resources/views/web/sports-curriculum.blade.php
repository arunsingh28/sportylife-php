@extends('layouts.main')
@section('style')
@endsection
@section('content') 
<div class="Workout_Videos">
    <div class="container">
        <h3> Sports Curriculum </h3>
        <div class="row">
            <div class="col-lg-1 col-md-0"></div>
            <div class="col-lg-10 col-md-12">
                <div class="row">
                    <div class="tab-content">
                        <div class="tab-pane fade in active show" id="navtabs">
                             @if(!empty($data[0]))
                            <div class="row " >
                                 @foreach($data as $key => $item)
                                 <!-- <div class='col-lg-3 col-md-6 portfolio-item filter-app'>
                                     <h2 class="upcom-hd" style="font-weight: 400 !important;">{{$item->title}}</h2>
                                    <a href="{{asset($item->video)}}" class='ply-btn-video'>
                                         <img src="{{asset($item->thumbnail)}}" class='img-fluid' alt=''>
                                    </a>
                                 </div> -->
                                 <div class="col-lg-3 col-md-6 portfolio-item1 mt-3 pt-3">
                                    <a href="{{asset($item->video)}}" class='ply-btn-video'>
                                    <img src="{{asset($item->thumbnail)}}" class="img-fluid" alt="">
                                    <div class="sess-time" style="width: 91.5% !important;text-align: center !important;">
                                        <p>{{$item->title}}</p>
                                    </div>
                                    </a>
                                 </div>
                                 @endforeach
                            </div>
                            @else
                            <h4 style="text-align: center;">No Data Available!</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-0"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection