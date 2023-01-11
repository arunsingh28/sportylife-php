@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="notification_page">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-0">
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="notification_Inner">
                    <h2>Notification</h2>
                    <h6>Today 
                        @if(!empty($previous[0]) || !empty($today[0]))
                        <span style="float: right;" onclick="notificationDelete('', 'all')">
                            Clear all
                        </span>
                        @endif
                    </h6>
                    @if(!empty($today[0]))
                    @foreach($today as $key => $item)
                    <div class="readable_allowed">
                        @if($item->image == NULL)
                        <img style="height: 59px !important;border-radius: 10px;" src="{{asset('uploads/images/notification_icon.png')}}">
                        @else
                        <img style="height: 59px !important;border-radius: 10px;" src="{{asset($item->image)}}">
                        @endif
                        <h5> {{$item->title ?? ''}}   <br> {{$item->data['body'] ?? ''}}  <br>  <span style="font-size: 12px;color: #838383;">{{$item->timediff ?? ''}} ago</span></h5>
                        <span style="float: right;padding: inherit;margin-top: 10px;">
                            <i class="fa fa-trash" onclick="notificationDelete({{$item->id}}, 'single')" style="color: red;"></i>
                        </span>
                    </div>
                    @endforeach
                    @else
                    <p>No Data Found!</p>
                    @endif
                    
                    <br>
                    <h6>Earlier</h6>
                    @if(!empty($previous[0]))
                    @foreach($previous as $key1 => $item1)
                    <div class="readable_allowed">
                        @if($item1->image == NULL)
                        <img style="height: 59px !important;border-radius: 10px;" src="{{asset('uploads/images/notification_icon.png')}}">
                        @else
                        <img style="height: 59px !important;border-radius: 10px;" src="{{asset($item1->image)}}">
                        @endif
                        <h5> {{$item1->title ?? ''}}  <br> {{$item1->data['body'] ?? ''}}  <br>  <span style="font-size: 12px;color: #838383;">{{$item1->timediff ?? ''}} ago</span></h5>
                        <span style="float: right;padding: inherit;margin-top: 10px;">
                            <i class="fa fa-trash" onclick="notificationDelete({{$item1->id}}, 'single')" style="color: red;"></i>
                        </span>
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
<script>
    function notificationDelete(notification_id,type) {
    
    $.ajax({
        url: "{{url('notificationDelete')}}",
        type: 'post',
        dataType: 'text',
        data: {
            'notification_id':notification_id,
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

</script>
@endsection