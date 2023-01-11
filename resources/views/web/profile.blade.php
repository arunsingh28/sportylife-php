@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="community_your">
    <div class="container">
        <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="community_sec">
                <a href="{{url('profile-edit/profile')}}" class="Edited">Edit </a>
                <img src="{{asset($user->image)}}" style="height: 150px;" class="pro_pi">
                <!--  <a href="#"> <img src="assets/img/camra.svg" class="pro_edit"> </a> -->
                <h2 class="pd45">{{$user->name ?? 'User'}}, {{$user->age}}</h2>
                <!-- <h4  class="pd45"> <img style="height: 20px;" src="{{asset($user->sport_image)}}"> {{$user->sport_name}}</h4> -->
                <a href="{{route('my-plans')}}"><h4  class="pd45" style="color:#e84033">My Plans <i class="fa fa-angle-right fa-sm"></i></h4></a>
                <h4 class="pd45">Active Plan: <span style="color: #25C200;"> <b> {{$user->active_plan}} </b> </span></h4>
                <!-- @if($user->profile_status < "100") --> 
                <!-- <div class="pro_section">
                    <img src="{{asset('web/assets/img/pro_user.png')}}">
                    <h5>Profile Completion<br> <span style="font-size: 22px;font-weight: bolder;"> {{$user->profile_status}}% </span></h5>
                    <a href="{{url('profile-edit/profile')}}"> <input type="button" class="btn-send" value="Complete your profile">
                    </a>
                </div> -->
                <!-- @endif -->
            </div>
        </div>
        </div>
    </div>
</div>
{{-- <div class="container mt-5">
    <h3 style="color:#fff;font-size: 25px;">Your Posts</h3>
    <div class="assign">
        <img class="puneeth" src="{{asset('web/assets/img/puneet.png')}}" class="">
        <h5> Puneeth Rajkumar <br><span style="font-size:11px;"> 7 November, 2021 </span> </h5>
        <!--  <a href="#">  <img class="doteds" src="{{asset('web/assets/img/Repeat_dotted.png')}}"> </a> -->
        <div class="dropdown doteds">
        <button type="button" class="dropdown-label">
            <img class="" src="{{asset('web/assets/img/Repeat_dotted.png')}}"> </a>
            <div class="dropdown-items">
                <a href="#" class="dropdown-item"> <img src="{{asset('web/assets/img/Edit.svg')}}"> Edit</a>
                <a href="#" class="dropdown-item"> <img src="{{asset('web/assets/img/delet.svg')}}"> Delete</a>
            </div>
        </div>
        <img src="{{asset('web/assets/img/back_punit.png')}}" class="w-100 mb-3 mt-2">
        <div class="row mt-2 social_share">
        <div class="col-lg-1 col-4">
            <a href="javascript:void(0)"> <img src="{{asset('web/assets/img/liking.svg')}}" style="width: 20px;"> <br> <span> 544
                </span> </a>
        </div>
        <div class="col-lg-1 col-4 text-center">
            <a href="javascript:void(0)"> <img src="{{asset('web/assets/img/massage.png')}}" style="width: 20px;"> <br> <span> 241
                </span> </a>
        </div>
        <div class="col-lg-10 col-4 text-right">
            <a href="javascript:void(0)"> <img src="{{asset('web/assets/img/shared.png')}}" style="width: 20px;"> <br> <span> 241
                </span> </a>
        </div>
        </div>
        <p>It is a long established fact that a reader will be distracted by the readable content of a page when
        looking at its layout. It is a long established fact that a reader will be distracted by the readable
        content of a page when looking at its layout.</p>
    </div>
</div>
<div class="container mt-5 pb-5">
    <div class="assign">
        <img class="puneeth" src="{{asset('web/assets/img/bask.png')}}" class="">
        <h5> Basketball Sunrise <br><span style="font-size:11px;"> 6 November, 2021 </span> </h5>
        <!--  <a href="#">  <img class="doteds" src="{{asset('web/assets/img/Repeat_dotted.png')}}"> </a> -->
        <div class="dropdown doteds">
        <button type="button" class="dropdown-label"> <img class="" src="{{asset('web/assets/img/Repeat_dotted.png')}}"> </a>
            <div class="dropdown-items">
                <a href="#" class="dropdown-item"> <img src="{{asset('web/assets/img/Edit.svg')}}"> Edit</a>
                <a href="#" class="dropdown-item"> <img src="{{asset('web/assets/img/delet.svg')}}"> Delete</a>
            </div>
        </div>
        <img src="{{asset('web/assets/img/running.png')}}" class="w-100 mb-3 mt-2">
        <div class="row mt-2 social_share">
        <div class="col-lg-1 col-4">
            <a href="javascript:void(0)"> <img src="{{asset('web/assets/img/liking.svg')}}" style="width: 20px;"> <br> <span> 544
                </span> </a>
        </div>
        <div class="col-lg-1 col-4 text-center">
            <a href="javascript:void(0)"> <img src="{{asset('web/assets/img/massage.png')}}" style="width: 20px;"> <br> <span> 241
                </span> </a>
        </div>
        <div class="col-lg-10 col-4 text-right">
            <a href="javascript:void(0)"> <img src="{{asset('web/assets/img/shared.png')}}" style="width: 20px;"> <br> <span> 241
                </span> </a>
        </div>
        </div>
        <p>It is a long established fact that a reader will be distracted by the readable content of a page when
        looking at its layout. It is a long established fact that a reader will be distracted by the readable
        content of a page when looking at its layout.</p>
        <div class="form-group">
        <textarea id="msg" style="border-radius: 15px;" name="message" class="form-control"
            placeholder="1st comment" rows="3" required=""></textarea>
        <a href="#"> <button class="msg_send_sub" type="button"> Submit</button> </a>
        </div>
        <br>
        <img class="puneeth" src="{{asset('web/assets/img/amel.svg')}}" class="">
        <h5> Amelli Smith, 20<br><span style="font-size:11px;"> Firstly identify and define the firstly identify and
            define the environment where this will </span> </h5>
        <h6> 12h &nbsp;&nbsp; | &nbsp;&nbsp; 1 Reply</h6>
        <div class="reply_sec">
        <img class="puneeth" src="{{asset('web/assets/img/amel.svg')}}" class="">
        <h5> Amelli Smith, 20<br><span style="font-size:11px;"> Firstly identify and define the firstly identify and
                define the environment where this will </span> </h5>
        </div>
        <hr style="border: 1px solid #555555;">
        <img class="puneeth" src="{{asset('web/assets/img/amel.svg')}}" class="">
        <h5> Amelli Smith, 20<br><span style="font-size:11px;"> Firstly identify and define the firstly identify and
            define the environment where this will </span> </h5>
        <h6> 12h &nbsp;&nbsp; | &nbsp;&nbsp; 1 Reply</h6>
        <div class="type_msg">
        <div class="input_msg_write">
            <input type="text" class="write_msg" placeholder="Type your comment...">
            <a href="#"> <button class="msg_send_btn" type="button"><img src="{{asset('web/assets/img/send.png')}}"> </button> </a>
        </div>
        </div>
    </div>
</div> --}}
@endsection
@section('script')
@endsection