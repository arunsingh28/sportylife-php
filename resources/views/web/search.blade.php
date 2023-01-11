@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="search_food">
   <div class="container">
      <div class="row">
         <div class="col-lg-2 col-md-0">
         </div>
         <div class="col-lg-8 col-md-12">
            <form class="card card-sm" action="#!">
               <div class="card-body row no-gutters align-items-center">
                  <div class="col-auto">
                     <img src="{{asset('web/assets/img/searc.svg')}}">
                  </div>
                  <div class="col">
                     <input class="form-control form-control-lg form-control-borderless" type="search" id="keyword" placeholder="Search food">
                  </div>
               </div>
            </form>
            <div class="row readering">
               <div class="col-lg-3 col-0 text-left">
               </div>
               <div class="col-lg-3 col-6 text-center">
                  <a href="#!" id="keyworddiv"><img src="{{asset('web/assets/img/history.svg')}}" style="width: 20px;"> </a>
                  {{-- <a onclick="return confirm('Are you sure you want clear search history?');" href="{{url('clearSerchHistory')}}" ><i class="fa fa-trash ml-2 mt-1" style="float:right;"></i> </a> --}}
               </div>
               <div class="col-lg-3 col-6 text-right">
                  <a href="#!" id="fav"><img src="{{asset('web/assets/img/liking.svg')}}" style="width: 20px;"> </a> 
               </div>
               <div class="col-lg-3 col-0 text-left">
               </div>
            </div> 
            
         </div>
         <div class="col-lg-2 col-md-0">
         </div>
      </div>
      <div class="row mt-5" >
         <div class="col-lg-2 col-md-0">
         </div>
         <div class="col-lg-8 col-md-12">
            <ul id="keyworddata"> 
               @foreach($recent_search as $key => $value)
               <li style="color: white;">{{$value->title}} </li>
               @endforeach
            </ul>
            <div class="row" id="favdata" style="display:none;">
               <div class="col-md-12">
                  @foreach($favourite_data as $key1 => $value1)
                  <div class="notification_Inner">
                     <div class="readable_allowed">
                        <div class="row">
                           <div class="col-md-12"> 
                              <div class="row">
                                 <div class="col-md-3">
                                    @if($value1->recipedata->type == "video") 
                                    <a href="{{url('recipe-details/?id='.$value1->recipedata->id)}}">
                                    <img style="height: 59px !important;border-radius: 10px;object-fit: cover;width: -webkit-fill-available;" src="{{asset($value1->recipedata->thumbnail)}}">
                                    </a> 
                                    @else
                                    <a href="{{url('recipe-details/?id='.$value1->recipedata->id)}}">
                                    <img style="height: 59px !important;border-radius: 10px;object-fit: cover;width: -webkit-fill-available;" src="{{asset($value1->recipedata->uploads)}}">
                                    </a>
                                    @endif
                                 </div> 
                                 <div class="col-md-7">
                                    <a href="{{url('recipe-details/?id='.$value1->recipedata->id)}}"><h5> {{\Str::limit($value1->recipedata->title, 100, '...')}}</h5></a>
                                 </div>
                                 <div class="col-md-2">
                                    <a href="{{url('recipe-details/?id='.$value1->recipedata->id)}}"><span style="font-size: 12px;color: #212121;border-radius: 10px;background: yellow;padding: 0px 7px 0px 7px;font-weight: 700;float: right;">Recipe</span></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
            <div class="row" id="searchhtmldata">
               
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
$(document).ready(function(){
   //  $("#favdata").hide();
});
// function getvideo(id) {
$("#fav").on('click',function(){
    $("#keyworddata").hide();
    $("#favdata").show();
});
$("#keyworddiv").on('click',function(){
    $("#keyworddata").show();
    $("#favdata").hide();
});
$("#keyword").on('keyup',function(){
   var keyword = $("#keyword").val();
    $.ajax({
        url: "{{url('/getSearchData')}}",
        type: 'post', 
        dataType: 'text',
        data: {
            'keyword':keyword,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
           if (data) {
            $('#searchhtmldata').html(data);
            $('#keyworddata').hide();
            $('#favdata').hide();
           }else{
              $('#searchhtmldata').html("No Data Found");
               $('#keyworddata').show();
           }
        },
        error: function(){
        }
    });
});

$("#keyword").on('focusout',function(){
   var keyword = $("#keyword").val();
    $.ajax({
        url: "{{url('/saveSearchData')}}",
        type: 'post', 
        dataType: 'text',
        data: {
            'keyword':keyword,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
           console.log("saved");
         //   if (data) {
         //    $('#searchhtmldata').html(data);
         //    $('#keyworddata').hide();
         //    $('#favdata').hide();
         //   }else{
         //      $('#searchhtmldata').html("No Data Found");
         //       $('#keyworddata').show();
         //   }
        },
        error: function(){
        }
    });
});
// }
</script>
@endsection