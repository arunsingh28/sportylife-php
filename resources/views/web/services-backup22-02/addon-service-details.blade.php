@extends('layouts.main')
@section('style')
@endsection
@section('content')
<main id="main" style="overflow-x:hidden;">
   <section id="pricing" class="pricing free_trial">
      <div class="container" data-aos="fade-up">
         <h2>Unlimited access to all stuff with a single membership</h2>
         <div id="carouselExample" class="carousel slide w-100" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="row" style="justify-content:center;">
                     <div class="col-lg-6 col-md-6 text-end">
                        <div class="box">
                           <div class="pac-ttl">
                              <img src="{{asset('web/assets/img/basic-pack.svg')}}" alt="" class="img-fluid">                
                              <div class="pac-txt">
                                 <h3>{{$packagedata->title}}</h3>
                                 <h4><sup><img src="{{asset('web/assets/img/rupees.svg')}}" alt="" class="img-fluid"></sup>{{$packagedata->price}}<span> / {{$packagedata->duration_type}}</span></h4>
                              </div>
                           </div>
                           <ul>
                              @foreach($packagedata->description as $key => $item)
                              <li><img src="{{asset('web/assets/img/meeting-point-b.svg')}}" alt="" class="img-fluid"> {{$item}}</li>
                              @endforeach 
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <div class="container">
      <form role="form" method="POST" action="{{ url('buynow') }}">
      @csrf
         <div class="row">
            <div class="col-lg-2 col-md-0">
            </div>
            <div class="col-lg-8 col-md-12">
               <div class="row">
                  <div class="col-md-12">
                     <input type="hidden" name="package_id" id="package_id" value="{{$package_id}}">
                     <input type="hidden" name="parent_package_id" id="parent_package_id" value="{{$parent_package_id ?? ''}}">
                     <input type="hidden" name="user_id" value="{{$user_id}}">
                     <input type="hidden" name="price" value="{{$price}}">
                     <input type="hidden" name="type" value="{{$type}}">
                     
                     <div class="select_port pt-0">
                        <ul>
                           @foreach($category as $key1 => $item1)
                           <li>
                              <input type="checkbox" name="category_data[{{$key1}}][id]" class="check" value="{{$item1->id}}" id="myCheckbox{{$item1->id}}">
                              <label for="myCheckbox{{$item1->id}}">
                              <img style="border-radius: 54%" src="{{asset($item1->image)}}">
                              </label>
                              {{$item1->title}}
                           </li>
                           
                           @endforeach
                        </ul>
                        <br>
                        <div class="row mb-5">
                           <hr>
                           <div class="row">
                              <div class="col-lg-3 col-md-0 col-0">
                              </div>
                              <!-- <div class="col-lg-3 col-md-6 col-12 mt-2">
                                 <button class="add_cart add_cart1" type="submit" name="click_type" value="cart" >Add To Cart</button>
                              </div> -->
                              <div class="col-lg-6 col-md-6 col-12 mt-2">
                                 <button class="buy_now add_cart1" type="submit" name="click_type" value="buynow">  Buy Now  </button>
                              </div>
                              <div class="col-lg-3 col-md-0 col-0">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-2 col-md-0">
            </div>
         </div>
      </form>
   </div>
</main>
@endsection
@section('script')
<script>
var checks = document.querySelectorAll(".check");
var max = '1';
var package_id = $("#package_id").val();
for (var i = 0; i < checks.length; i++)
  checks[i].onclick = selectiveCheck;
function selectiveCheck (event) {
  var checkedChecks = document.querySelectorAll(".check:checked");
  if (checkedChecks.length >= parseInt(max) + 1){
     return false;
  }else{
      $(".add_cart1").removeAttr("disabled");
  }
//   if (package_id == "3") {
//       if (checkedChecks.length == 2){
//          $(".add_cart1").attr("disabled",'disabled');
//       }else{
//          $(".add_cart1").removeAttr("disabled");
//       }
//    }
   
}
$(document).ready(function(){
   $('.add_cart1').attr('disabled', 'disabled');
})

$(function() {
    $('.check').click(function() {
        if ($(this).is(':checked')) {
            $('.add_cart1').removeAttr('disabled');
        } else {
            $('.add_cart1').attr('disabled', 'disabled');
        }
    });
});
</script>

</script>
@endsection