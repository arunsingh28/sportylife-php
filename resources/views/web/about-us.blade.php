@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="about_us">
   <div class="container">
      @if(!empty($content1))
      
      <div class="row">
         @if(!empty($content1->des_image))
         <div class="col-lg-6 col-md-12">
            <img src="{{asset(@$content1->des_image)}}" alt="" class="img-fluid">
         </div>
         @endif
         <div class="col-lg-6 col-md-12">
            <h2> {{@$content1->title}}</h2>
            {{-- <h2> About the <span style="color: #ef4234;font-weight: 700;"> Sporty Life </span> </h2> --}}
            <p>{!! @$content1->description !!}</p>
         </div>
      </div>
      @endif
      @if(!empty($content2))
      <br><br>
      <div class="row mt-5">
         <div class="col-lg-6 col-md-12">
             <h2> {{@$content2->title}}</h2>
            <p> {!! @$content2->description !!}</p>
         </div>
         @if(!empty($content2->des_image))
         <div class="col-lg-6 col-md-12">
            <img src="{{asset(@$content2->des_image)}}" alt="" class="img-fluid">
         </div>
         @endif
      </div>
      @endif
   </div>
   {{-- <div class="container mt-5">
      <div class="row mt-3">
         <h2 class="text-center">Exclusive Members</h2>
         @if(!empty($members[0]))
         @foreach($members as $key => $item)
         <div class="col-lg-3 col-md-6">
            <div class="flip-card">
               <div class="flip-card-inner">
                  @if(!empty($item->member_image))
                  <div class="flip-card-front">
                     <img src="{{asset($item->member_image)}}" class="img-fluid" alt="">
                  </div>
                  @endif
                  <div class="flip-card-back">
                     <h1>{{@$item->member_name}}</h1>
                     <p>{{@$item->member_role}}</p>
                     <div class="social-links text-center text-md-right pt-3 pt-md-0">
                        <a target="_blank" href="{{@$item->facebook_link}}" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a target="_blank" href="{{@$item->instagram_link}}" class="instagram"><i class="bx bxl-instagram"></i></a>
                        <a target="_blank" href="{{@$item->youtube_link}}" class="linkedin"><i class="bx bxl-youtube"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
         @else
         <p style="text-align: center;color: #ef4234;">No Data Available!</p>
         @endif
         
      </div>
   </div> --}}
   <!-- <div class="container newsletter">
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
</div>
@endsection
@section('script')
@endsection