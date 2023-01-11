@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="Setting_strt">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-0">
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="setting_Inner">
                    <h2>Settings</h2>
                    
                    <div class="reading">
                        <a href="{{route('web.contact-us')}}">
                            <h5> Contact Us</h5>
                        </a>
                    </div>
                    <div class="reading">
                        <a href="{{route('web.faq')}}">
                            <h5> FAQ </h5>
                        </a>
                    </div>
                    <div class="reading">
                        <a href="{{route('invite-friends')}}">
                            <h5> Invite Friend </h5>
                        </a>
                    </div>
                    <div class="reading">
                        <a href="{{route('diary')}}">
                            <h5> My Diary </h5>
                        </a>
                    </div>
                    <div class="reading">
                        <a href="{{url('terms-conditions')}}" target="_blank">
                            <h5> Terms & Conditions </h5>
                        </a>
                    </div>
                    <div class="reading">
                        <a href="{{url('privacy-policy')}}" target="_blank">
                            <h5> Privacy Policy </h5>
                        </a>
                    </div>
                    <div class="reading">
                        <a href="{{route('web.update-password')}}">
                            <h5> Change Password</h5>
                        </a>
                    </div>
                    <div class="reading">
                        <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <h5> Logout</h5>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-0">
            </div>
        </div>
        <h1 class="center_logo"><a href="{{route('index')}}"><img src="{{asset('web/assets/img/logo-updated3.png')}}" alt="" class="img-fluid" style="width:17% !important"></a></h1>
    </div>
</div>
@endsection
@section('script')
@endsection