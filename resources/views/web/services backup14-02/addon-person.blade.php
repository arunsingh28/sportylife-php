@extends('layouts.main')
@section('style')
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>
<style>
   /* .list-group-item {
   display: flex;
   align-items: center;
   } */
   .highlight {
   /* background: #212121;
   min-height: 30px; */
   list-style-type: none;
   }
   .handle {
   min-width: 18px;
   background: #607D8B;
   height: 15px;
   display: inline-block;
   cursor: move;
   margin-right: 10px;
   }
   .ui-sortable{
   position: relative !important;
   }
   .btn-send{
   width: -webkit-fill-available !important;
   }
   select.one, select.two, select.three {
   background-position: calc(100% - 20px) 21px !important;
   }
   @media (max-width: 1366px){
   .child {
   padding: 5px 10px !important;
   }
   }
   .height {
   line-height: 39px !important;
   }

   .disablediv {  
     pointer-events: none;  
   }
</style>
@endsection
@section('content')
<div class="contact_start">
   <div class="container">
      <div class="row">
         <div class="col-lg-2 col-md-0">
         </div>
         <div class="col-lg-8 col-md-12">
            <h2>Addon Person</h2>
            <div class="cont_sec">
               <form role="form" method="POST" action="{{ url('orderPlace') }}">
                  @csrf
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">                
                           <input id="name" type="text" name="first_name" class="form-control" value="{{auth()->user()->first_name}}" placeholder="First Name" required="required">                         
                        </div>
                        <div class="form-group">                
                           <input id="name" type="text" name="email" class="form-control" value="{{auth()->user()->email}}" placeholder="Email ID" required="required">                         
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">                
                           <input id="name" type="text" name="last_name" class="form-control" value="{{auth()->user()->last_name}}" placeholder="Last Name" required="required">                         
                        </div>
                        <div class="form-group">                
                           <input id="name" type="text" name="phone" class="form-control" value="{{auth()->user()->phone}}" placeholder="Phone" required="required">                         
                           <input id="user_id" name="user_id" type="hidden"  value="{{auth()->user()->id}}" >                         
                        </div>
                     </div>
                     <div class="col-md-12 Product_del mt-2">
                        @if(!empty($data))
                        <h5>Product Details:</h5>
                        <input id="order_id" name="order_id" type="hidden"  value="{{$amountdetails['order_id']}}" >                         
                        <input name="click_type" type="hidden"  value="buynow">        
                        <input name="type" type="hidden"  value="addon_person">                     
                        <input name="package_id" type="hidden"  value="{{$data->id}}">                     
                        <!-- <hr> -->
                        <ul class=" list-part">
                           
                           <div id="sort_menu" data-sort_menu_id="" class="sort_menu mb-3"  style="border: 1px solid gray !important;padding: 13px !important;border-radius: 11px !important;">
                              <label>{{$data->title}}</label>
                              
                              <!-- <span class="badge " title="remove"  style="color: white;border-radius: 4px;background: #ef4234;padding: 7px 9px 7px 9px;font-weight: 700;float: right;margin-left: 10px;"><i class="fa fa-times"  style="margin-top: 2px;" ></i></span> -->
                              
                              <span class="badge" style="color: #212121;border-radius: 4px;background: yellow;padding: 8px;font-weight: 700;float: right;">&#x20B9; {{$data->price}}</span>
                              <!-- <hr> -->
                              @if($data->addon_adult_count > 0 || $data->addon_kid_count > 0 )
                              <hr>
                              <div class="col-md-12 Product_del" style="margin-top: -21px !important;">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <h5 style="padding-bottom: 0px !important;margin: 13px auto 0 !important;float: left !important;">Person's List</h5>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                       @if($data->addon_adult_count > 0 || $data->addon_kid_count > 0 )
                                       <span class="badge" style="color: white;border-radius: 4px;background: #373737;padding: 8px;font-weight: 400;float: right;" data-toggle="modal" data-target="#personaddon{{$data->id}}">Add Person</span>
                                       <!-- @if($data->remaining_adult_count > 0 || $data->remaining_kid_count > 0 )
                                       @else
                                          <span class="badge" style="color: white;border-radius: 4px;background: #373737;padding: 8px;font-weight: 400;float: right;" >Add Person</span>
                                       @endif -->
                                       @endif
                                    </div>
                                 </div>   
                                 <!-- <h5 style="padding-bottom: 0px !important;">Person's List</h5> -->
                                 <!-- <ul class=" list-part mt-4">
                                    <li class="list-group-item">
                                       <label>Note: You can add total {{$data->addon_adult_count}} Adult and {{$data->addon_kid_count}} Kid</label><br>
                                       <label style="color:red;">Remaining: You can add total {{$data->remaining_adult_count}} Adult and {{$data->remaining_kid_count}} Kid</label>
                                    </li>
                                 </ul> -->
                                
                                 <hr class="mt-1">
                                 <ul class=" list-part" id="listhtml{{$data->id}}">
                                    @if(!empty($data->addonperson))
                                    <li class="list-group-item">
                                       <label>1. {{$data->addonperson->person_first_name}}</label>  <span ><i style="float: right;" class="fa fa-trash" onclick="removePerson(<?php echo $data->addonperson->id; ?>,<?php echo $data->id; ?>)"></i></span>
                                    </li>
                                    @endif
                                 </ul>
                              </div>
                                 @endif

                           </div>
                           
                           <hr class="hr.new3">
                           <li class="list-group-item">
                              <label>Total Price</label>  <span class="badge">&#x20B9; {{$amountdetails['total_price']}}</span>
                              <input type="hidden" name="total_price" value="{{$amountdetails['total_price']}}">
                           </li>
                           <li class="list-group-item">
                              <label>Discount Amount</label> <span class="badge">(-) &#x20B9; {{$amountdetails['discount_amount']}}</span>
                              <input type="hidden" name="discount_amount" value="{{$amountdetails['discount_amount']}}">
                           </li>
                           <li class="list-group-item mt-3">
                              <label>Total Amount</label> <span class="badge">&#x20B9; {{$amountdetails['total_price_after_discount']}}</span>
                              <input type="hidden" name="total_price_after_discount" value="{{$amountdetails['total_price_after_discount']}}">
                           </li>
                           <li class="list-group-item">
                              <label>GST</label>  <span class="badge">(+) &#x20B9; {{$amountdetails['gst_amount']}}</span>
                              <input type="hidden" name="gst_percentage" value="{{$amountdetails['gst_percentage']}}">
                              <input type="hidden" name="gst_amount" value="{{$amountdetails['gst_amount']}}">
                           </li>
                           <li class="list-group-item">
                              <label>Final Amount</label> <span class="badge">&#x20B9; {{$amountdetails['final_amount']}}</span>
                              <input type="hidden" name="final_amount" value="{{$amountdetails['final_amount']}}">
                           </li>
                        </ul>
                        @else
                        <h5 class="mt-4">No Item Available!</h5>
                        @endif
                     </div>
                     <div class="col-md-12">
                        @if(!empty($data))
                        <div class="row">
                           <!-- <div class="col-md-6">
                              <input type="button"  class="btn-send"   value="Remove Item">
                           </div> -->
                           <div class="col-md-12">
                              <input type="submit" class="btn-send" value="Continue To Payment">
                           </div>
                        </div>
                        @endif
                     </div>
                  </div>
                  </form>
                  <!-- model -->
                  <!-- person model -->
                  @if(!empty($data))
                     @if($data->addon_adult_count > 0 || $data->addon_kid_count > 0 )
                     <div class="modal fade personmodal" id="personaddon{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
                        <div class="modal-dialog" style="margin-top: 12%;max-width: 50%!important;" role="document">
                           <div class="modal-content">
                              <div class="modal-header" >
                                 <h5 class="modal-title" id="personaddonLabel" style="padding-bottom: 0px !important;">Person Details</h5>
                                 <button type="button" class="close btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <div class="cont_sec" style="padding: 20px !important;border: 0px solid #707070 !important;">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <input id="person_package_id" type="hidden" name="person_package_id" value="{{$data->id}}" class="form-control" >
                                             <input id="addon_type" type="hidden" name="addon_type" value="adult" class="form-control" >
                                             <input id="person_first_name" type="text" name="person_first_name" class="form-control" placeholder="First Name" required="required">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <input id="person_last_name" type="text" name="person_last_name" class="form-control" placeholder="Last Name"
                                                required="required">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <input id="person_email" type="email" name="person_email" class="form-control" placeholder="Email ID"
                                                required>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <input id="person_phone" type="text" name="person_phone" class="form-control" placeholder="Phone"
                                                required>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <input id="dob" type="text" name="dob" onchange="checkPersonType();"  class="form-control" placeholder="dd-mm-yyyy"
                                                required="required" autocomplete="off" >
                                          </div>
                                       </div>
                                       
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="parent" style="margin-top: 7px !important;">
                                                <label class="child bak" for="male">
                                                <img src="{{asset('web/assets/img/toilet.svg')}}"> 
                                                Male
                                                </label>
                                                <input type="radio" id="male" checked name="gender" value="male" style="display:none;">
                                                <label class="child" for="female">
                                                <img src="{{asset('web/assets/img/female.svg')}}"> 
                                                Female
                                                </label>
                                                <input type="radio" id="female" name="gender" value="female" style="display:none;">
                                                <label class="child" for="other">
                                                <img src="{{asset('web/assets/img/other.svg')}}"> 
                                                Other
                                                </label>
                                                <input type="radio" id="other" name="gender" value="gender" style="display:none;">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group" >
                                             <h6 class="hgt_sec">Weight Type</h6>
                                             <select name="weight_type" required class="one mb-0 mt-0" id="weight_type">
                                                <option value="Kilogram" selected>Kilogram</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <h6 class="hgt_sec">Weight Type</h6>
                                          <div class="form-group" style="position: relative;">
                                             <input id="weight" type="text" name="weight"  class="form-control" placeholder="Weight"
                                                required="required">
                                             <a href="#!">
                                                <h6 class="kg" style="width: 28% !important;top:7px !important;">&nbsp;&nbsp;&nbsp;Kilogram</h6>
                                             </a>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group" >
                                             <h6 class="hgt_sec">Height Type</h6>
                                             <select name="height_type" required  class="one mb-0 mt-0" id="height_type">
                                                <option value="Centimeter" selected>Centimeter</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <h6 class="hgt_sec">Height</h6>
                                             <div class="height">
                                                <input style="margin-left: 28px !important;" class="otp" id="height_feet" name="height_feet"  type="text" placeholder="cm" maxlength="15">
                                                <input  class="otp" id="height_inch" name="height_inch"  style="border-right: none;" type="text"  placeholder="mm" maxlength="15">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <h6 class="hgt_sec">State</h6>
                                             <select class="one mb-0 mt-0 " id="state" name="state"> 
                                                <option value="">Select Option</option>
                                                @foreach($state_data as $item)
                                                <option value="{{$item->name}}" >{{$item->name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <h6 class="hgt_sec">City</h6>
                                             <select class="one mb-0 mt-0 " id="city" name="city"> 
                                                <option value="">Select Option</option>
                                                @foreach($city_data as $item)
                                                <option value="{{$item->name}}" >{{$item->name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <h6 class="hgt_sec">Preferred languages</h6>
                                          <div class="form-group">
                                             <select class="one" id="language_id" name="language_id" style="margin-top: 1px !important;height: 44px !important;padding: 10px 15px !important;background-position: calc(100% - 20px) 18px !important;">
                                                @foreach($languages as $item)
                                                <option value="{{$item->id}}">{{$item->language_title}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <h6 class="hgt_sec">Relation</h6>
                                          <div class="form-group">
                                             <input id="relation" type="text" name="relation"  class="form-control" placeholder="Relation"
                                                required="required">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <p id="errorText" style="color:white;"></p>
                                 <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                 <button type="button" class="btn btn-sm btn-secondary" onclick="addPerson({{$data->id}});">Add</button>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endif
                  @endif
                  <!-- person model -->
                  <!-- model -->
               
            </div>
         </div>
         <div class="col-lg-2 col-md-0">
         </div>
      </div>
      
   </div>
</div>
@endsection
@section('script')
<script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script>

   
   var elements = document.getElementsByClassName("child");
   for(var i = 0; i < elements.length; i++)
   {
   elements[i].onclick = function(){
      // remove class from sibling
      var el = elements[0];
      while(el)
      {
            if(el.tagName === "LABEL"){
               //remove class
               el.classList.remove("bak");
            }
            // pass to the new sibling
            el = el.nextSibling;
      }
      this.classList.add("bak");  
      };
   }
</script>
<script>
   function removefromcart(id) {
      if (!confirm('Are you sure you want to delete this?')) {
         return false;
      }
      
      var item_id = id;
      // var item_id = $("#item_id").val();
      var user_id = $("#user_id").val();
       $.ajax({
           url: "{{url('removeFromCart')}}",
           type: 'post',
           dataType: 'json',
           data: {
              'user_id':user_id,
              'item_id':item_id,
           },
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           success: function(data){
            if (data.statusCode == "200") {
                  toastr.success(data.message)
                  location.reload(true);
            }else{
                  toastr.error(data.message)
               }
            },
            error: function(){
               
            }
       });
   }
   
   function checkPersonType() {
      var dob = $("#dob").val();
      $.ajax({
           url: "{{url('checkPersonType')}}",
           type: 'post',
           dataType: 'json',
           data: {
              'dob':dob,
           },
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           success: function(data){
            if (data.statusCode == "200") {
                  $('#addon_type').val(data.person_type);
            }else{
                  $('#addon_type').val('');
               }
            },
            error: function(){
               
            }
       });
   }
   function addPerson(package_id) {
      
      var order_id = $("#order_id").val();
      var addon_type = $("#addon_type").val();
      var user_id = $("#user_id").val();
      var package_id = package_id;
      var person_first_name = $("#person_first_name").val();
      var person_last_name = $("#person_last_name").val();
      var person_email = $("#person_email").val();
      var person_phone = $("#person_phone").val();
      var dob = $("#dob").val();
      if (!dob) {
         return false;
      }
      // var gender = $("#gender").val();
      var gender = $("input[type='radio'][name='gender']:checked").val();
      var city = $("#city").val();
      var state = $("#state").val();
      var weight = $("#weight").val();
      var height_feet = $("#height_feet").val();
      var height_inch = $("#height_inch").val();
      var language_id = $("#language_id").val();
      var relation = $("#relation").val();
   
       $.ajax({
           url: "{{url('addonPerson')}}",
           type: 'post',
           dataType: 'json',
           data: {
              'order_id':order_id,
              'addon_type':addon_type,
              'user_id':user_id,
              'package_id':package_id,
              'person_first_name':person_first_name,
              'person_last_name':person_last_name,
              'person_email':person_email,
              'person_phone':person_phone,
              'dob':dob,
              'gender':gender,
              'city':city,
              'state':state,
              'weight':weight,
              'height_feet':height_feet,
              'height_inch':height_inch,
              'language_id':language_id,
              'relation':relation,
           },
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           success: function(data){
            if (data.statusCode == "200") {
                  $('.personmodal').hide();
                  //  $(".personmodal").modal({backdrop: false});
                  toastr.success(data.message)
                  // var obj = jQuery.parseJSON(data);
                  $("#listhtml"+package_id).empty();
                  // $.each(data.data, function (key, value) {
                  //    var key1 = key + parseInt(1);
                  // });
                     $("#listhtml"+package_id).append('<li class="list-group-item"><label>1. '+data.data[0].person_first_name+'</label>  <span ><i style="float: right;" class="fa fa-trash" onclick="removePerson('+data.data[0].id+')"></i></span></li>');
                  // location.reload(true);
            }else{
                  toastr.error(data.message)
                  // $('#personaddon').modal('show');
                  $('#errorText').html(data.message).css('color','red');
               }
            },
            error: function(){
               
            }
       });
   }
   function removePerson(id,package_id) {
      if (!confirm('Are you sure you want to delete this?')) {
         return false;
      }
      var user_id = $("#user_id").val();
      var order_id = $("#order_id").val();
       var package_id = package_id;
      $.ajax({
           url: "{{url('removePerson')}}",
           type: 'post',
           dataType: 'json',
           data: {
              'id':id,
              'user_id':user_id,
              'order_id':order_id,
              'package_id':package_id
           },
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           success: function(data){
               if (data.statusCode == "200") {
                  toastr.success(data.message);
                  $("#listhtml"+package_id).empty();
                  // $.each(data.data, function (key, value) {
                  //    var key1 = key + parseInt(1);
                  // });
                     $("#listhtml"+package_id).append('<li class="list-group-item"><label>1. '+data.data[0].person_first_name+'</label>  <span ><i style="float: right;" class="fa fa-trash" onclick="removePerson('+data.data[0].id+','+package_id+')"></i></span></li>');
                  // location.reload(true);
               }else{
                  toastr.error(data.message);
               }
            },
            error: function(){
               
            }
       });
   }
   
</script>
@endsection