@extends('layouts.main')
@section('style')
<style lang="">
    #social-links{
        margin-left: 35%;
        margin-top: 3px;
    }
    /* .issend{
        background: #22ab26 !important;
    } */
</style>
@endsection
@section('content')
<div class="nutrition_blogs_details pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-0">
            </div>
            <div class="col-lg-10 col-md-12 tortila">
                <!-- <img src="{{asset($recipedata->uplaod)}}" alt="" class="img-fluid"> -->
                <div style="text-align:center;">

                    @if($recipedata->type == 'image')
                    <img src="{{asset($recipedata->uploads)}}" class="img-fluid" alt="">
                    @else
                    <a href="{{asset($recipedata->uploads)}}" class='ply-btn-video'><img src="{{asset($recipedata->thumbnail)}}" class='img-fluid' alt=''></a>
                    @endif
                </div>
                <div class="portfolio-info">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <h1>{{$recipedata->title}}</h1>
                        </div>
                        <div class="col-lg-4 col-md-4 pull-right">
                            <img src="{{asset('web/assets/img/layer2.svg')}}" alt="">
                            <!-- <img src="{{asset('web/assets/img/likede.svg')}}" alt=""> -->
                            <div class="stage">
                                <div class="heart <?php if($recipedata->is_like == "1"){echo "is-active";}?>" onclick="likerecipe({{$recipedata->id}},'favourite')"></div>
                                
                            </div>
                            {!! $shareRecipe !!}
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="col-lg-1 col-md-0">
            </div>
        </div>
        <div class="row mt-5 ">
            <div class="col-lg-1 col-md-0">
            </div>
            <div class="col-lg-5 col-md-6 Preface">
                <h4 class="pt-0">Preparation</h4>
                <p>{!! $recipedata->preparation !!}</p>
                <a href="#!">  <input type="button" class="btn-send issend mb-3" id="adddiarybutton" value="<?php if($recipedata->is_in_diary == "1"){echo "Added to diary";}else{echo "Add to diary";}?>" onclick="likerecipe({{$recipedata->id}},'diary')"> </a>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-6 mt-2">
                        <div class="intro">
                            <h6>{{$recipedata->calorie}}</h6>
                            <span>Calorie (Kcal)</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mt-2">
                        <div class="intro">
                            <h6>{{$recipedata->protein}}</h6>
                            <span>Protein (Gm)</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mt-2">
                        <div class="intro">
                            <h6>{{$recipedata->carbs}}</h6>
                            <span>Carbs (Gm)</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mt-2">
                        <div class="intro">
                            <h6>{{$recipedata->fats}}</h6>
                            <span>Fats (Gm)</span>
                        </div>
                    </div>
                    <div class="col-md-12 Product_del mt-4">
                        <ul class="list-part" style="margin-bottom: 0rem !important; ">
                            <li class="list-group-item">
                                <label>1. Time taken to prepare recipe</label>  <span class="badge">{{$recipedata->preparation_time ?? ''}} (Min)</span>
                            </li>
                            <li class="list-group-item">
                                <label>2. How many can be served</label>  <span class="badge">{{$recipedata->person_to_serve ?? ''}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 Product_del mt-4">
                        
                        <h5>Ingredients</h5>
                        <hr>
                        <ul class="list-part">
                            @foreach($recipedata->ingredients as $key => $item)
                            <li class="list-group-item">
                                <label>{{$item['name']}}</label>  <span class="badge">{{$item['quantity']}}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
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
function likerecipe(id,type) {
    $.ajax({
        url: "{{url('recipeLike')}}",
        type: 'post',
        dataType: 'text',
        data: {
            'recipe_id':id,
            'type':type,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            console.log(data);
            var res = JSON.parse(data);
            if (res.statusCode == "200") {
                toastr.success(res.message);
                if (type == "diary") {
                    $("#adddiarybutton").attr("value","Added to Diary") ;
                }else{
                    $(".heart").toggleClass("is-active");
                }
                $(".issend").css("background","#22ab26 !important") ;
            }else if(res.statusCode == "300"){
                toastr.error(res.message)
                if (type == "diary") {
                    $("#adddiarybutton").attr("value","Add to Diary");
                }else{
                    $(".heart").removeClass("is-active");
                }
                $(".issend").css("background","#373737 !important") ;
            }else{
                toastr.error(res.message)
            }
        },
        error: function(){
        }
    });
}

$(document).on("click",".social-button",function() {
    var id = $('#recipe_id').val();
    
    $.ajax({
        url: "{{url('recipeShare')}}",
        type: 'post',
        dataType: 'text',
        data: {
            'recipe_id':id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            console.log(data);
            var res = JSON.parse(data);
            if (res.statusCode == "200") {
                console.log(res.message);
            }else{
                toastr.error(res.message)
            }
        },
        error: function(){
        }
    });
});

$(document).on("click","#submitcomment",function() {
    var recipe_id = $('#recipe_id').val();
    var message = $('#message').val();
    if (!message) {
        return false;
    }
    $.ajax({
        url: "{{url('addrecipeComment')}}",
        type: 'post',
        dataType: 'json',
        data: {
            'recipe_id':recipe_id,
            'message':message,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            console.log(res);
            var res = data;
            if (res.statusCode == "200") {
                toastr.success(res.message);
            }else{
                toastr.error(res.message)
            }
        },
        error: function(){
        }
    });
});
</script>
@endsection