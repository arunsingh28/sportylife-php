@extends('layouts.main')
@section('style')

@endsection
@section('content')
<div class="invite_friend">
    <div class="container">
        <h2> Invite Friend </h2>
        <div class="row invite_friend_inner">
            <!-- <div class="invite_friend_inner"> -->
            <div class="col-lg-4 col-md-12 p-0">
                <img src="{{asset('web/assets/img/pic3.png')}}">
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="get_code">
                    <p> Get the exclusive benefits by sharing the app with your friends </p>
                    <button class="w3-btn w3-black">Refer Code: <b>{{Auth::user()->referral_code}} </b></button>
                    {{-- <button class="w3-btn w3-teal"> <img src="{{asset('web/assets/img/share.svg')}}"> Invite</button> --}}
                </div>
                <!-- </div> -->
                <hr style="width: 80%;margin: 30px auto 0;text-align: center;display: block;">
                <h6><a href="{{route('web.invite-history')}}"> Invite History >> </a></h6>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection