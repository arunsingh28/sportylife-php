@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="nutrition_blog">
    <div class="container">
        <h2>News Feeds</h2>
        <div class="row">
            @foreach($blogs as $item)
            <div class="col-lg-3 col-md-6 mt-5">
                <a href="{{url('news-feed-details/'.$item->slug)}}">	
                    @if($item->type == "image")
                    <img src="{{asset($item->uploads)}}" class="w-100" style="height: 50%; object-fit: cover;"> 
                    @else
                    <img src="{{asset($item->thumbnail)}}" class="w-100" style="height: 50%; object-fit: cover;"> 
                    @endif
                </a>
                
                <div class="bottom_sec">
                    <h6>{{date('M d, Y',strtotime($item->created_at))}}</h6>
                    <h3>{!! Str::limit($item->title, 40, ' ...') !!}</h3>

                    <div class="row">
                        <div class="col-lg-4 col-4 text-left">
                            <a href="javascript:void(0)"> <img src="{{asset('web/assets/img/eye.svg')}}" style="width: 20px;"> <span> {{$item->view_count}}</span> </a>
                        </div>
                        <div class="col-lg-4 col-4 text-center">
                            <!-- <a href="javascript:void(0)"><img src="{{asset('web/assets/img/liked.svg')}}" style="width: 20px;"> <span> {{$item->like_count}}</span> </a> -->
                        </div>
                        <div class="col-lg-4 col-4 text-right">
                            <a href="javascript:void(0)"><i class="fa fa-thumbs-up fa-lg" style="<?php if($item->is_like == "1"){echo "color:red;";}?>"> </i><span> {{$item->like_count}}</span> </a>
                            <!-- <a href="javascript:void(0)"><img src="{{asset('web/assets/img/shares.svg')}}" style="width: 20px;"> <span> {{$item->share_count}}</span> </a>  -->
                        </div>
                    </div>
                </div>	

            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection