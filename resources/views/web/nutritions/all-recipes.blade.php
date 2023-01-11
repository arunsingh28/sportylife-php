@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="my_dairy">
    <div class="container">
        <h2>{{ucfirst($categorydata->title)}}</h2>
        <div class="row">
            <div class="col-lg-1 col-md-0"></div>
            <div class="col-lg-10 col-md-12">
                <div class="row">
                    @foreach($recipedata as $key => $item)
                    <div class="col-lg-3 col-md-6 portfolio-item filter-app">
                        <a href="{{url('recipe-details/?id='.$item->id)}}">  
                            @if($item->type == 'image')
                            <img src="{{asset($item->uploads)}}" class="img-fluid" style="object-fit: cover !important;height: 100% !important;border-radius: 10px;" alt="">
                            @else
                            <a href="{{asset($item->uploads)}}" class='ply-btn-video'><img src="{{asset($item->thumbnail)}}" class='img-fluid' style="object-fit: cover;height: 100%;border-radius: 10px;" alt=''></a>
                            @endif
                        </a>
                        <div class="portfolio-info">
                            <a href="{{url('recipe-details/?id='.$item->id)}}"> <h4>{{$item->title}}</h4>
                            <a href="#!">{{$item->calorie ?? '0'}} cal </a> </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-1 col-md-0"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection