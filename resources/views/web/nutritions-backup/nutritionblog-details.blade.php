@extends('layouts.main')
@section('style')

@endsection
@section('content')
<div class="nutrition_blogs_details">
    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-md-0">
            </div>
            <div class="col-lg-10 col-md-12">
                <div style="text-align: center;">
                    <img src="{{asset($blogdetail->image)}}" alt="" class="img-fluid"></a>

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
                        <a href="#!" onclick="likeblog({{$blogdetail->id}})"><i class="fa fa-thumbs-up" id="likebutton" style="<?php if($blogdetail->is_like == "1"){echo "color:red;";}?>"> </i><span id="likecount" style="margin-left:4px;">{{$blogdetail->like_count}}</span> </a> 
                    </div>
                    <div class="col-lg-4 col-4 text-right">
                        <a href="#!" ><img src="{{asset('web/assets/img/shares.svg')}}" style="width: 20px;"> <span id="sharecount" style="margin-left:4px;">{{$blogdetail->share_count}}</span> {!! $shareBlog !!}</a> 
                        
                    </div>
                </div>
                <div class="row mt-2">
                    <h4>Leave A Comment</h4>
                    <div class="col-md-12">
                        <div class="form-group">                
                            <input type="hidden" id="blog_id" value="{{$blogdetail->id}}">
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
                    <img class="puneeth" style="height: 38px;border-radius: 9px;margin-bottom: 5px; margin-right: 5px;" src="{{asset($item->userdata->image)}}" >
                    <span style="font-size:18px;color:#fff;">{{$item->userdata->name}}</span><h5 style="color:#fff;"> <span style="font-size:14px;color:#fff;"> {{$item->message}}  </span> </h5>
                    <h6 style="color:#fff;"> {{$item->timediff}} &nbsp;&nbsp; </h6>
                    <hr style="border: 1px solid #555555;">
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
        url: "{{url('blogLike')}}",
        type: 'post',
        dataType: 'text',
        data: {
            'blog_id':id,
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

$(document).on("click",".social-button",function() {
    var share = $('#sharecount').text();
    var id = $('#blog_id').val();
    
    $.ajax({
        url: "{{url('blogShare')}}",
        type: 'post',
        dataType: 'text',
        data: {
            'blog_id':id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            console.log(data);
            var res = JSON.parse(data);
            if (res.statusCode == "200") {
                // toastr.success(res.message);
                $('#sharecount').text(parseInt(share) + 1);
            }else{
                toastr.error(res.message)
            }
        },
        error: function(){
        }
    });
});

$(document).on("click","#submitcomment",function() {
    var blog_id = $('#blog_id').val();
    var message = $('#message').val();
    if (!message) {
        return false;
    }
    $.ajax({
        url: "{{url('addblogComment')}}",
        type: 'post',
        dataType: 'json',
        data: {
            'blog_id':blog_id,
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