@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="my_dairy">
    <div class="container">
        <h2>Recipes</h2>
        <div class="row">
            <div class="col-lg-1 col-md-0"></div>
            <div class="col-lg-10 col-md-12">
                @foreach($data as $key => $item)
                <div class="row">
                    <h5>{{$item->title}}</h5>
                    <span><a href="{{url('recipes/'.$item->slug)}}">See All </a></span> 
                    @foreach($item->nutrition_recipedata->take(4) as $key1 => $item1) 
                    <div class="col-lg-3 col-md-6 portfolio-item filter-app">
                        <a href="{{url('recipe-details/?id='.$item1->id)}}">  
                            @if($item1->type == 'image')
                            <img src="{{asset($item1->uploads)}}" class="img-fluid" style="object-fit: cover !important;height: 100% !important;border-radius: 10px;" alt="">
                            @else
                            <a href="{{asset($item1->uploads)}}" class='ply-btn-video'>
                                <img src="{{asset($item1->thumbnail)}}" class='img-fluid' style="object-fit: cover;height: 100%;border-radius: 10px;" alt=''>
                            </a>
                            @endif
                        <div class="portfolio-info">
                            <a href="{{url('recipe-details/?id='.$item1->id)}}"><h4>{{$item1->title}}</h4></a>
                        </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            <div class="col-lg-1 col-md-0"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection