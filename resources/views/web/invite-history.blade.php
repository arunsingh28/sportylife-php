@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="notification_page">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-0">
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="notification_Inner">
                    <h2>Invite History</h2>
                    @foreach($data as $key => $item)
                    <div class="readable_allowed">
                        <img src="{{asset('web/assets/img/invitation.svg')}}">
                        <h5> <strong> {{$item->name}} </strong> just accepted your invitation <br>  
                            <span style="font-size: 12px;color: #838383;"> Date: {{date('d M, Y', strtotime($item->created_at))}} </span>
                        </h5>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-2 col-md-0">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection