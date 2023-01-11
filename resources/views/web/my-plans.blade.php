@extends('layouts.main')
@section('style')
<style>
    .btn-sm {
        border-radius: 0.9rem !important;
    }
    .marginleft{
        margin-left: 20px !important;
    }
</style>
@endsection
@section('content')
<div class="notification_page">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-0">
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="notification_Inner">
                    <h2>My Plans</h2>
                    @if(!empty($result[0]))
                    @foreach($result as $key => $item)
                    
                    <!-- <input type="hidden" name="type" value="addon_sport"> -->
                    <div class="readable_allowed ">
                        @if($item->type == "addon_sport")
                            <h5> <span>Type : Add-On Sport</span></h5>
                        @elseif($item->type == "addon_person")
                            <h5> <span>Type : Add-On Person</span></h5>
                        @else
                            <h5> <span>Type : Main Package</span></h5>
                        @endif
                        <br>
                        <h5> <span>Order ID : {{$item->order_id}}</span></h5>
                        <hr class="mt-1 mb-1">
                        @foreach($item->package as $key1 => $value1)
                        <form role="form" method="POST" action="{{ url('addon-sport') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                           
                            <div class="" style="margin-top: 10px;">
                                @if($key1 > 0)
                                <hr class="marginleft" style="color: white;">
                                @endif 
                                <span style="font-size: 12px;color: white;border-radius: 10px;background: #1a1a1a;padding: 0px 10px 0px 10px;font-weight: 700;margin-left: 22px;">{{$key1+1}}</span>
                                <h5  style="margin-left: 9px !important;"> <span>Package :<span style="font-size: 14px;color: white;border-radius: 10px;padding: 0px 10px 0px 10px;font-weight: 700;margin-left: 10px;"> 
                                @if($item->type == "sport")
                                {{@$value1->package_data->title}}
                                @else
                                {{@$value1['package_data']['title']}}
                                @endif 
                                </span> </span></h5> 
                                <!-- <h5  style="margin-left: 9px !important;"> <span style="font-size: 14px;color: #212121;border-radius: 4px;background: yellow;padding: 0px 10px 0px 10px;font-weight: 700;margin-left: 283px;"> 
                               &#x20B9; 500
                                 </span></h5> -->
                                @if(!empty($value1->item)) 
                                <br>
                                <h5 class="marginleft"><span>Expire On : {{date('M d, Y',strtotime(@$value1->expiry_date))}}</span></h5>
                                <br>
                                <h5 class="marginleft"><span>Start On : {{date('M d, Y',strtotime(@$value1->start_date))}}</span></h5>
                                <hr class="mt-1 mb-2 marginleft"> 
                                @if($value1['package_data']['is_sports_show'] == '1')
                                <h5 class="marginleft"><span>Active Sports</span>
                                <hr class="mt-1 mb-1">
                                </h5>

                                <br>
                                <span class="marginleft">
                                
                                @foreach($value1->item as $key2 => $item2)
                                <span style="font-size: 14px;color: white;border-radius: 19px;background: #0d6efd;padding: 5px 10px 5px 10px;font-weight: 600;">{{$item2->category_detail->title}}</span>
                                @endforeach
                                
                                </span>

                                <br>
                                @endif
                                @endif
                                <br>
                                @if($item->type == "sport")
                                    @if($value1->package_data->addon == '1')
                                        @if($value1->addon_package_data != NULL)
                                            
                                        <input type="hidden" name="package_id" id="package_id" value="{{$value1->package_data->id}}">
                                        <input type="hidden" name="price" id="price" value="{{$value1->package_data->price}}">
                                            
                                        <div class="row  mb-2">
                                            <div class="col-md-6" style="text-align-last: center;">
                                                <button type="submit" class="btn btn-secondary btn-sm mt-2" name="adddon_type" value="addon_sport" style="background:#0c0c0c !important;width: 60%;"> Add Sport </button>
                                            </div>
                                            {{-- @if($value1->package_data->addon_adult_count > 0 || $value1->package_data->addon_kid_count > 0 )
                                            
                                                <div class="col-md-6" style="text-align-last: center;">
                                                    <button type="submit" class="btn btn-secondary btn-sm mt-2" name="adddon_type" value="addon_person" style="background:#0c0c0c !important;width: 60%;"> Add Person </button>
                                                </div>
                                            
                                            @endif --}}
                                        </div>
                                        @else
                                        <div class="row  mb-2">
                                            <div class="col-md-6" style="text-align-last: center;">
                                                <button type="button" onclick="return alert('Addon Package Not Found!')" class="btn btn-secondary btn-sm mt-2" name="adddon_type" value="addon_sport" style="background:#0c0c0c !important;width: 60%;"> Add Sport </button>
                                            </div>
                                            {{-- @if($value1->package_data->addon_adult_count > 0 || $value1->package_data->addon_kid_count > 0 )
                                            
                                                <div class="col-md-6" style="text-align-last: center;">
                                                    <button type="button" onclick="return alert('Addon Package Not Found!')" class="btn btn-secondary btn-sm mt-2" name="adddon_type" value="addon_person" style="background:#0c0c0c !important;width: 60%;"> Add Person </button>
                                                </div>
                                            
                                            @endif --}}
                                        </div>
                                        @endif
                                    @endif
                                @endif

                            </div>
                        </form>
                        @endforeach
                    </div>
                    
                    @endforeach
                    @else
                    <p>No Data Found!</p>
                    @endif
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