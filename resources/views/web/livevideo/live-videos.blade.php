@extends('layouts.main')
@section('style')
@endsection
@section('content') 
<div class="Workout_Videos">
   <div class="container">
      <h3>SportyLive</h3>
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="row">
               <ul class="nav nav-tabs" id="myNavTabs">
                  @foreach($day_name as $key => $value)
                  <li><a class="<?php if($key == "0"){echo "active";}  ?>" href="#navtabs{{$key}}" data-toggle="tab" class="">{{$value}}</a></li>
                  @endforeach
               </ul>
               <div class="tab-content">
                  @if (!empty($data[0]))
                      
                  
                  @foreach($data[0] as $key1 => $value1)
                  <div class="tab-pane fade in <?php if($key1 == "0"){echo "active";}  ?>" id="navtabs{{$key1}}">
                     @if(!empty($value1[0]))
                     @if($key1 == '0')
                     <h2 class="upcom-hd">Upcoming Sessions</h2>
                     <div class="row">
                        @foreach($value1 as $key2 => $value2)
                        <div class="col-md-3 portfolio-item filter-app"> 
                           <img src="{{asset($value2->thumbnail)}}" class="img-fluid" alt="">
                           <div class="sess-time">
                              <div class="row">
                                 <div class="col-md-6"><span>{{$value2->dayname}}</span></div>
                                 <div class="col-md-6 text-end">
                                    <a class="" href="{{url('live-sessions-details/'.$value2->id)}}">
                                       <img style="height: auto;width:auto;border-radius: 0px !important;" src="{{asset('web/assets/img/live-tv.svg')}}" class="img-fluid" alt=""> 
                                       Join</a>
                                 </div>
                              </div>
                              <h4>{{date('h:i a',strtotime($value2->start_date_time))}} to {{date('h:i a',strtotime($value2->end_date_time))}}</h4>
                              <p>{{$value2->title}}</p>
                           </div>
                        </div>
                        @endforeach
                     </div>
                     @endif
                     <div class="row <?php if($key1 == "0"){echo "mt-5 pt-5";}  ?>">
                        @foreach($value1 as $key2 => $value2)
                        <div class="col-md-4 portfolio-item1">
                           <h2 class="upcom-hd">{{$value2->title}}</h2>
                           <a class="" href="{{url('live-sessions-details/'.$value2->id)}}">
                           <img src="{{asset($value2->thumbnail)}}" class="img-fluid" alt="">
                           <div class="sess-time">
                              <div class="row">
                                 <div class="col-md-12"><span>{{$value2->dayname}}</span></div>
                              </div>
                              <h4>{{date('h:i a',strtotime($value2->start_date_time))}} to {{date('h:i a',strtotime($value2->end_date_time))}}</h4>
                              <p>{{$value2->title}}</p>
                           </div>
                           </a>
                        </div>
                        @endforeach
                     </div>
                     @else
                     <h4 style="text-align: center;">No Session Available!</h4>
                     @endif
                  </div>
                  @endforeach
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
@endsection