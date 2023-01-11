@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="Workout_Videos">
    <div class="container">
        <h3> Workout Videos </h3>
        <div class="row">
            <div class="col-lg-1 col-md-0"></div>
            <div class="col-lg-10 col-md-12">
                <div class="row">
                    <ul class="nav nav-tabs" id="myNavTabs">
                        @foreach($workoutvideo as $key => $cat)
                        <li>
                            <a class="" href="#nav{{$cat->id}}" data-toggle="tab" id="categoryid" data-id="{{$cat->id}}" onclick="getvideo({{$cat->id}})" class="">{{$cat->title}}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active show" id="navtabs">
                            <div class="row" id="htmldata">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-0"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        var id = $("#categoryid").attr('data-id');
        $("#categoryid").addClass('active');
        getvideo(id);
    });

    function getvideo(id) {
        $.ajax({
            url: "{{url('/getVideos')}}",
            type: 'post',
            dataType: 'text',
            data: {
                'category_id': id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('#htmldata').html(data);
                // if (data.statusCode == "200") {
                //     // $(data.data).each(function( key, value ) {
                //     //     $("#language_id").append('<option value='+value.id+'>'+value.language_title+'</option>')
                //     // });
                // }else{
                //     toastr.error(data.message)
                // }
            },
            error: function() {}
        });
    }
</script>
@endsection