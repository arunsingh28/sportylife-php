@extends('layouts.main')
@section('style')
<style type="text/css">
    .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 17px;
    width: 17px;
    /*border: 1px #0073aa dashed;
    */  transition: all 0.5s ease-in-out;
    border-radius: 5px;
    background-color: #fff;
    }
    .checkbox-container {
    //display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    float: right;
    }
    /* Hide the browser's default checkbox */
    .checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
    }
    /* On mouse-over, add a grey background color */
    .checkbox-container:hover input ~ .checkmark {
    /*background-color: #ccc;*/
    }
    /* When the checkbox is checked, add a blue background */
    .checkbox-container input:checked ~ .checkmark {
    background-color: #fff;
    transition: all 0.5s ease-in-out;
    border-radius: 50%;
    }
    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
    content: "";
    position: absolute;
    display: none;
    }
    /* Show the checkmark when checked */
    .checkbox-container input:checked ~ .checkmark:after {
    display: block;
    }
    /* Style the checkmark/indicator */
    .checkbox-container .checkmark:after {
    left: 6px;
    top: 3px;
    width: 5px;
    height: 10px;
    border: solid #373737;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    }
    .btn-send1{
        background: #fff;
        border-radius: 22px;
        width: 100%;
        border: 1px solid #212121;
        height: 36px;
        display: block;
        color: #212121;
        font-size: 16px;
        margin-top: 5px;
        font-weight: 700;
     }
     .cont_sec {
        background: #373737 !important;
        padding: 0px !important;
        border-radius: 0px !important;
        border: 0px solid #707070 !important;
    }
    .cont_sec .form-group {
        margin-bottom: 0px !important;
    }

    
</style>
@endsection
@section('content')
<div class="community_your">
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-0">
            </div>
            <div class="col-lg-10 col-md-12">
                <div class="community_sec">
                    <img src="{{asset($user->image)}}" style="height: 150px;" class="pro_pi">
                    <h2>{{$user->name ?? 'User'}} </h2>
                    <h4> <span style="font-size: 18px;"> {{$user->age}}, {{ucfirst($user->gender)}} </span></h4>
                </div>
                <div class="row Recipe">
                    <div class="col-lg-4 col-md-6">
                        <div class="diet_chart">
                            <a href="{{route('diet-chart')}}">
                                <img src="{{asset('web/assets/img/diet.png')}}" class="pro_pi">
                                <h3>Diet Chart</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="diet_chart">
                            <a href="{{route('recipes')}}">
                                <img src="{{asset('web/assets/img/recipe-book.png')}}" class="pro_pi">
                                <h3>Suggested Recipe</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <form role="form" method="POST" action="{{ route('meals-complete') }}">
                        @csrf
                            <div class="diet_chart Completed">
                                <img src="{{asset('web/assets/img/cooking.png')}}" class="pro_pi">
                                <h3>Meals Completed</h3>
                                <input type="hidden" name="type" value="single">
                                <ul>
                                    @foreach($frqudata as $key => $item)
                                    <li>
                                        <a href="#">  
                                            <img src="{{asset('web/assets/img/right-arrow.png')}}"> {{$item->title}} 
                                        </a>  
                                        <label class="checkbox-container"> 
                                            <input type="checkbox" name="meal_data[][category_id]" value="{{$item->id}}" <?php if($item->is_complete == "1"){echo "checked onClick='return false;'";} ?> >
                                            <span class="checkmark"></span>
                                        </label> 
                                    </li>
                                    @endforeach
                                    @if($addonmealcount > 0)
                                    <li>
                                        <a href="#!" style="color:white;">  
                                            <img src="{{asset('web/assets/img/right-arrow.png')}}"> {{$addonmealcount}} Extra Meal Added
                                        </a>  
                                        <label class="checkbox-container"> 
                                            <input type="checkbox" checked disabled>
                                            <span class="checkmark"></span>
                                        </label> 
                                    </li>
                                    @endif
                                    <li>
                                        <a href="#!" style="color:white;"  data-toggle="modal" data-target="#exampleModal">  
                                           <i class="fa fa-plus-square"></i>&nbsp; Add Extra Meal
                                        </a> 
                                    </li>
                                    <input type="submit" class="btn-send" value="Save">
                                    
                                </ul>
                            </div>
                        </form>
                        <!-- model -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="margin-top: 12%;" role="document">
                                <div class="modal-content">
                                    <form role="form" method="POST" action="{{ route('meals-complete') }}">
                                    @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Extra Meal</h5>
                                            <button type="button" class="close btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="cont_sec">
                                            <input type="hidden" name="type" value="addon">
                                            <div class="row">
                                                <div class="col-md-12"> 
                                                    <h6 class="hgt_sec">Choose Category</h6>
                                                    <div class="form-group">                
                                                        <select class="one" name="meal_data[0][category_id]" id="freq_id"> 
                                                            <option value="" >Select Category</option>
                                                            @foreach($frqudata as $key => $item)
                                                            <option value="{{$item->id}}" >{{$item->title}}</option>
                                                            @endforeach
                                                        </select>                       
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h6 class="hgt_sec">Choose Meals</h6>
                                                    <div id="htmldata">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-sm btn-secondary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- model -->
                    </div>
                </div>
                <div class="row mt-5 publishing ">
                    @foreach($recipecate as $key => $item)
                    <div class="col-lg-3 col-md-3">
                        <a href="{{url('recipes/'.$item->slug)}}"><img style="height: 60%;border-radius:10px" src="{{asset($item->image)}}" class="pro_pi">
                        <h3>{{$item->title}}</h3></a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-1 col-md-0">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
$("#freq_id").change(function(){
    var frequency_id = $("#freq_id").val();
    if (!frequency_id) {
        $('#htmldata').empty();
        return false;
    }
    console.log(frequency_id);
    $.ajax({
        url: "{{url('/getMealsbyFrequency')}}",
        type: 'post',
        dataType: 'text',
        data: {
            'frequency_id':frequency_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            $('#htmldata').html(data);
        },
        error: function(){
        }
    });
});
</script>
@endsection