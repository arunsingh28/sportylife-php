@extends('layouts.main')
@section('style')
<style>
    .Cinnamon .nav-tabs li {
        display: block;
    }
    .Cinnamon ul#myNavTabs {
        background: #fff;
        border-radius: 10px 30px 30px 30px;
        margin-bottom: 0px;
    }
    .Cinnamon .nav-tabs li a {
        color: #000;
        text-align: left;
        display: block;
        line-height: 30px;
        border-bottom: 2px dotted #bdbdbd;
        text-transform: capitalize;
        font-size: 16px;
    }
    .Cinnamon .list-group-item {
    border-bottom: 1px dotted #fff;
        color: #fff;
        background: transparent;
        line-height: 32px;
        font-size: 16px;
        font-weight: 700;
    }
    .Cinnamon  ul.list-part {
        margin-bottom: 0px;
    }
    .Cinnamon .nav-tabs h5 {
        font-weight: 700;
        color: #000;
        text-align: left;
        padding: 20px 0px 5px;
        border-bottom: 2px solid #707070;
        width: 90%;
        margin: 0 auto;
        font-size: 18px;
    }
</style>
@endsection
@section('content')
<div class="chart_diet">
    <div class="container">
        <h2>Diet Chart</h2>
        <div class="row">
            <div class="col-lg-1 col-md-0">
            </div>
            <div class="col-lg-10 col-md-12">
                <div class="Cinnamon">
                    <div class="row" style="border: 1px solid #CECFD2; border-radius: 10px 30px 30px 30px;">
                        <div class="col-lg-4 col-md-4 col-12" style="padding: 0;">
                        <ul class="nav nav-tabs" id="myNavTabs">
                                <h5>Frequency</h5> 
                            @foreach($customarr1 as $key => $item)
                                <li>
                                    <a class="<?php if($key == "0"){echo "active";} ?>" href="#navtabs{{$item['frequency_id']}}" data-toggle="tab">{{$item['frequency_name']}}</a>
                                </li>
                            @endforeach
                        </ul>
                        </div>
                        <div class="col-lg-8 col-md-8 col-12">
                            <div class="tab-content">
                            @foreach($customarr1 as $key => $item)
                                <div class="tab-pane fade in <?php if($key == "0"){echo "active show";} ?>" id="navtabs{{$item['frequency_id']}}">
                                    <div class="row">
                                        <ul class="list-part">
                                            <li style="border-bottom:2px solid #fff;" class="list-group-item">
                                                <label>{{$item['frequency_name']}}</label>  <span class="badge">Qty</span>
                                            </li>
                                        </ul>

                                        <ul class="list-part">
                                            @foreach($item['meal'] as $key3 => $item4)
                                            <li class="list-group-item">
                                                <label>{{$item4['meal_name']}}</label>  <span class="badge">{{$item4['quantity']}}</span>
                                            </li>
                                            @endforeach
                                            
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        </div>
                    </div> 
                    <div class="row mt-5 mid_evening">
                        <div class="col-lg-7 col-md-6 col-6">
                            <h4>Note:</h4>
                            <ul>
                                <li>1 Bowl = {{$note['bowl']}}</li>
                                <li>1 Cup = {{$note['cup']}}</li>
                                <li>1 glass = {{$note['glass']}}</li>
                                <li>1 tbsp = {{$note['tbsp']}}</li>
                                <li>1 tsp = {{$note['tsp']}}</li>
                            </ul>
                        </div>
                        <div class="col-lg-5 col-md-6 col-6">
                            {{-- <a href="{{asset($pdfurl)}}" target="_blank" download class="btn-get-started"> <img src="{{asset('web/assets/img/download.png')}}" alt=""> Download </a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-0">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection