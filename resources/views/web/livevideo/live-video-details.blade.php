@extends('layouts.main')
@section('style')
<style>
    audio::-webkit-media-controls-timeline,
video::-webkit-media-controls-timeline {
    display: none;
}
/* audio::-webkit-media-controls,
video::-webkit-media-controls {
    display: none;
} */
/* video::-webkit-media-controls-fullscreen-button,  */
video::-webkit-media-controls-play-button, 
video::-webkit-media-controls-pausebutton {
    display: none;
}
</style>
@endsection
@section('content') 
<div class="nutrition_blogs_details">
    <div class="container">
        <div class="row mt-5 pt-5">
            <div class="col-md-6">
                @if($data->is_play == '0')
                <img style="border-radius: 15px;" src="{{asset($data->thumbnail)}}" alt="" class="img-fluid"></a>
                @else 
                <a href="{{asset($data->video).'#t='.$data->difference.','.$data->length}}" onclick="return false" class='ply-btn-video1'><img style="border-radius: 15px;" src="{{asset($data->thumbnail)}}" class='img-fluid' alt=''></a> 
                @endif
                
            </div>
            <div class="col-md-6">
                <h2 class="pt-0">{{$data->title}}</h2>
                <p>{!! $data->description !!}</p>
                <div class="readers">
                        <div class="calnd">
                            <img src="{{asset('web/assets/img/calendar.svg')}}" style="height: 25px;"> 
                        </div>
                        <p class="cal-p">
                            {{$data->start_date}}
                            <span>{{date('h:i:s a',strtotime($data->start_date_time))}} to {{date('h:i:s a',strtotime($data->end_date_time))}}</span>
                        </p>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <a class="act-pack" href="#!" style="max-width: -webkit-fill-available !important;">Active Plan: <span>{{$data->package_name ?? 'N/A'}}</span></a>
                    </div>
                    <div class="col-md-12" style="text-align:-webkit-center !important;">
                        @if($data->is_play == '1'  || $user->is_purchase == '1')
                        <input type="button" class="btn-send live-bt" style="max-width: -webkit-fill-available !important;" data-toggle="modal" data-target="#exampleModal" value="Join Now">
                        @else 
                        <input type="button" class="btn-send live-bt" style="max-width: -webkit-fill-available !important;"  value="Join Now">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- videopopup -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"  data-backdrop='static' data-keyboard='false' aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="margin-top: 8%;" role="document">
                <div class="modal-content" style="background-color: transparent !important;border: 0px !important;">
                        <div class="modal-header" style="border-bottom: 0px !important;">
                            <h5 class="modal-title" style="margin-left: 97%;margin-bottom: -24px !important;" id="exampleModalLabel">
                                <button type="button" class="close btn btn-sm btn-secondary " style="background-color: transparent !important;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            </h5>
                        </div>
                        <div class="modal-body">
                            <video controls controlsList="nodownload noplaybackrate noloop"  disablepictureinpicture src="{{asset($data->video).'#t='.$data->difference.','.$data->length}}" preload="metadata" id="myVideo" style="border-radius: 15px;" class="img-fluid"> </video>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
        <!-- videopopup -->
    </div>
</div>
@endsection
@section('script')
<script>
$("#exampleModal").on('show.bs.modal', function(){
    var video = document.querySelector("#myVideo");
    video.play()
    video.onpause = () => { video.play(); }
    $.ajax({
        url: "{{url('/liveVideoUser')}}",
        type: 'post',
        dataType: 'text',
        data: {
            'video_id':'<?php echo $data->id; ?>',
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            console.log(data);
        },
        error: function(){
        }
    });
});
$("#exampleModal").on('hide.bs.modal', function(){
    var confirmed = confirm("Are you sure?");
    if (!confirmed) {
        return false; 
    }
    location.reload();
});
document.getElementById('myVideo').addEventListener('ended',myHandler,false);
function myHandler(e) {
    var video = document.querySelector("#myVideo");
    video.pause()
    video.currentTime = 0;
    // document.getElementById('myVideo').pause();
    alert("Your session has been ended!");
    location.reload();
}

// $(".playvideo").on('click',function(e){
//     e.preventDefault();

//     $('.ply-btn-video1').magnificPopup({
//             disableOn: 700,
//             type: 'iframe',
//             mainClass: 'mfp-fade',
//             removalDelay: 160,
//             preloader: false,
//             fixedContentPos: true,
//             callbacks: {
//                 open: function () {
//                     //liveVideoUser
//                     $.ajax({
//                         url: "{{url('/liveVideoUser')}}",
//                         type: 'post',
//                         dataType: 'text',
//                         data: {
//                             'video_id':'<?php echo $data->id; ?>',
//                         },
//                         headers: {
//                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                         },
//                         success: function(data){
//                             console.log(data);
//                             $(".mfp-content video").prop('controlsList', 'nodownload');
//                         },
//                         error: function(){
//                         }
//                     });
//                     //liveVideoUser

//                     $.magnificPopup.instance.close = function () {
//                         var confirmed = confirm("Are you sure?");
//                         if (!confirmed) {
//                             return;
//                         }
//                         $.magnificPopup.proto.close.call(this);
//                         location.reload();
//                     };
//                 }
//             }
//     }).magnificPopup('open');
    
// });
      
</script>
@endsection