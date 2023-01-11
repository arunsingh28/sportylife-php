@extends('layouts.main')
@section('style')
<style>
    .cont_sec {
        padding: 0px;
        border: 0px solid #707070;
    }
</style>
@endsection
@section('content')
<div class="nutrition_blogs_details">
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-0">
            </div>
            <div class="col-lg-10 col-md-12">
                <div style="text-align: center;">
                    @if($blogdetail->type == "image")
                    <img src="{{asset($blogdetail->uploads)}}" alt="" class="img-fluid">
                    @else
                    {{-- <img src="{{asset($blogdetail->thumbnail)}}" class="img-fluid" >  --}}
                    <a href="{{asset($blogdetail->uploads)}}" class='ply-btn-video'><img src="{{asset($blogdetail->thumbnail)}}" class='img-fluid' alt=''></a>
                    @endif

                </div>
                <h2>{{$blogdetail->title}}</h2>
                <p>{!! $blogdetail->description !!}
                </p>
                <div class="row readers">
                    <div class="col-lg-4 col-4 text-left">
                        <a href="javascript:void(0)"> <img src="{{asset('web/assets/img/eye.svg')}}" style="width: 20px;"> <span> {{$blogdetail->view_count}}</span> </a>
                    </div>
                    <div class="col-lg-4 col-4 text-center">
                        <!-- <a href="javascript:void(0)"><img src="{{asset('web/assets/img/liked.svg')}}" style="width: 20px;"> <span> {{$blogdetail->like_count}}</span> </a> -->
                        <!-- <input type="hidden" id="likecount" value="{{$blogdetail->like_count}}"> -->
                    </div>
                    <div class="col-lg-4 col-4 text-right">
                        <a href="#!" onclick="likeblog({{$blogdetail->id}})"><i class="fa fa-thumbs-up" id="likebutton" style="<?php if($blogdetail->is_like == "1"){echo "color:red;";}?>"> </i><span id="likecount" style="margin-left:4px;">{{$blogdetail->like_count}}</span> </a> 
                        {{-- <a href="#!" ><img src="{{asset('web/assets/img/shares.svg')}}" style="width: 20px;"> <span id="sharecount" style="margin-left:4px;">{{$blogdetail->share_count}}</span> {!! $shareBlog !!}</a>  --}}
                        
                    </div>
                </div>
                <div class="row mt-2">
                    <h4>Leave A Comment</h4>
                    <div class="col-md-12">
                        <div class="form-group">                
                            <input type="hidden" id="news_feed_id" value="{{$blogdetail->id}}">
                            <textarea id="message" style="border-radius: 15px;" name="message" class="form-control" placeholder="Leave your message here" rows="3" required=""></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="button" id="submitcomment" class="btn-send" value="Submit">
                    </div>
                </div>
                <br>
                @if(!empty($commentlist))
                    @foreach($commentlist as $key => $item)
                    @if(!empty($item->userdata->image))
                    <img class="puneeth" style="height: 38px;border-radius: 9px;margin-bottom: 5px; margin-right: 5px;" src="{{asset($item->userdata->image)}}" >
                    @else
                    <img class="puneeth" style="height: 38px;border-radius: 9px;margin-bottom: 5px; margin-right: 5px;" src="{{asset('uploads/images/dummy_male.png')}}" >
                    @endif
                    @if(auth()->user()->id  == $item->user_id)
                    <span style="float:right;">
                        <i class="fa fa-trash" onclick="commentDelete({{$item->id}}, 'newsfeed')" style="color: red;"></i>
                        <i class="fa fa-pencil" data-toggle="modal" data-target="#exampleModal{{$item->id}}" style="color: green;"></i>
                    </span>
                    @endif
                    <span style="font-size:18px;color:#fff;">{{$item->userdata->name ?? 'User'}}</span><h5 style="color:#fff;"> <span style="font-size:14px;color:#fff;"> {{$item->message ?? ''}}  </span> </h5>
                    <h6 style="color:#fff;"> {{$item->timediff ?? ''}} ago&nbsp;&nbsp; </h6>
                    <hr style="border: 1px solid #555555;">

                    <!-- model -->
                    <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="margin-top: 12%;" role="document">
                            <div class="modal-content">
                                <form role="form" method="POST" action="{{ route('commentEdit') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Comment</h5>
                                        <button type="button" class="close btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="cont_sec">
                                            <div class="row">
                                                <div class="col-md-12"> 
                                                    <h6 class="hgt_sec">Comment</h6>
                                                    <input type="hidden" name="comment_id" value="{{$item->id}}">
                                                    <input type="hidden" name="type" value="newsfeed">
                                                    <div class="form-group">                
                                                        <textarea id="message" style="border-radius: 15px;" name="message" class="form-control" placeholder="Leave your message here" rows="3" value="{{$item->message}}" required="">{{$item->message}}</textarea>
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
                    @endforeach
                @endif
                <!-- <img class="puneeth" src="{{asset('web/assets/img/bask.png')}}" class="">
                <h5 style="color:#fff;"> Amelli Smith, 20<br><span style="font-size:11px;color:#fff;"> Firstly identify and define the firstly identify and define the environment where this will  </span> </h5>
                <h6 style="color:#fff;"> 12h &nbsp;&nbsp; </h6> -->
                
            </div>
            <div class="col-lg-1 col-md-0"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
function likeblog(id) {
    var like = $('#likecount').text();
    
    $.ajax({
        url: "{{url('news-feeds-like')}}",
        type: 'post',
        dataType: 'text',
        data: {
            'news_feed_id':id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            console.log(data);
            var res = JSON.parse(data);
            if (res.statusCode == "200") {
                toastr.success(res.message);
                $('#likecount').text(parseInt(like) + 1);
                $('#likebutton').css("color","red");
            }else if(res.statusCode == "300"){
                toastr.error(res.message)
                $('#likebutton').css("color","");
                $('#likecount').text(parseInt(like) - 1);
            }else{
                toastr.error(res.message)
            }
        },
        error: function(){
        }
    });
}

function commentDelete(comment_id,type) {
    
    $.ajax({
        url: "{{url('commentDelete')}}",
        type: 'post',
        dataType: 'text',
        data: {
            'comment_id':comment_id,
            'type':type,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            console.log(data);
            var res = JSON.parse(data);
            if (res.statusCode == "200") {
                location.reload(true);
            }else{
                toastr.error(res.message)
            }
        },
        error: function(){
        }
    });
}



$(document).on("click","#submitcomment",function() {
    var news_feed_id = $('#news_feed_id').val();
    var message = $('#message').val();
    if (!message) {
        return false;
    }
    $.ajax({
        url: "{{url('addNewsFeedsComment')}}",
        type: 'post',
        dataType: 'json',
        data: {
            'news_feed_id':news_feed_id,
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
                location.reload(true);

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