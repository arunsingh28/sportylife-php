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
            <h2>Buy Now</h2>
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
                        @if(!empty($data[0]['categorydata']))
                        <h5>Product Details:</h5>
                        <input id="order_id" name="order_id" type="hidden"  value="{{$amountdetails['order_id']}}" >
                        <input name="click_type" type="hidden"  value="buynow">        
                        <input name="type" type="hidden"  value="{{$type ?? 'sport'}}">                    
                        <!-- <hr> -->
                        <ul class=" list-part">
                           @foreach($data as $key1 => $item1)
                           <input id="type" name="store[{{$key1}}][type]" type="hidden"  value="{{$item1['type']}}">                         
                           <input id="item_id" name="store[{{$key1}}][item_id]" type="hidden"  value="{{$item1['id']}}" >       
                           <input id="package_id" name="store[{{$key1}}][package_id]" type="hidden"  value="{{$item1['package_id']}}" >
                           @if($type == "addon_sport" || $type == "addon_person")
                              <input name="package_id" type="hidden"  value="{{$data[0]->packagedata->id}}">
                           @endif 

                           <div class="sort_menu mb-3"  style="border: 1px solid gray !important;padding: 13px !important;border-radius: 11px !important;">
                              <label>{{$item1->packagedata->title}}</label>
                              <span class="badge " title="remove" onclick="removefromcart(<?php echo $item1['id']; ?>);" style="color: white;border-radius: 4px;background: #ef4234;padding: 7px 9px 7px 9px;font-weight: 700;float: right;margin-left: 10px;"><i class="fa fa-times"  style="margin-top: 2px;" ></i></span>
                              <span class="badge" style="color: #212121;border-radius: 4px;background: yellow;padding: 8px;font-weight: 700;float: right;">&#x20B9; {{$item1->packagedata->price}}</span>
                              <hr>

                              <div class="col-md-12 Product_del" style="margin-top: -21px !important;">
                                 <div class="row" style="background: #373737;padding: 0px;border-radius: 11px;">
                                    <div class="col-md-6">
                                       <h6 style="padding-bottom: 10px !important;margin: 9px auto 0 !important;float: left !important;">Sports List</h6>
                                    </div>
                                    <div class="col-md-6">
                                       <span class="badge" style="color: white;border-radius: 4px;background: #212121;font-weight: 400;float: right;margin-top: 7px;" data-toggle="modal" data-target="#addsportModal{{$item1['package_id']}}">Add/Edit Sport</span>
                                    </div>
                                 </div>
                                 <div id="sort_menu{{$key1+1}}" data-sort_menu_id="{{$item1['id']}}" class="sort_menu mt-2"  >
                                    @foreach($item1['categorydata'] as $key => $item)
                                    <li class="list-group-item"  data-id="{{$item->id}}">
                                       <i data-p_id="{{$item1['id']}}" class="fa fa-arrows rearrange mt-1 " title="Drag Up/Down To Change" aria-hidden="true"></i> 
                                       <label class="" style="margin-left: 8px;">{{$key+1}}. {{$item->title}}</label>  
                                       <span class="badge" style="border-radius: 4px;padding: 2px 3px 2px 3px;font-weight: 700;float: right;">
                                          &#x20B9; {{$item->sport_price}}</span>
                                          <!-- @if($item->sport_price == '0')
                                          Free
                                          @else
                                       @endif -->
                                       <input id="items" name="store[{{$key1}}][items][]" type="hidden"  value="{{$item->id}}" >
                                    </li>
                                    @endforeach 
                                 </div>
                              </div>
                              @if($type == "addon_person" || $type == "sport")
                                 @if($item1->packagedata['addon_adult_count'] > 0 || $item1->packagedata['addon_kid_count'] > 0 )
                                 <hr class="mt-0" style="">
                                 <div class="col-md-12 Product_del" style="margin-top: -21px !important;">
                                    <div class="row" style="background: #373737;padding: 0px;border-radius: 11px;">
                                       <div class="col-md-6">
                                          <h6 style="padding-bottom: 10px !important;margin: 9px auto 0 !important;float: left !important;">Person's List</h6>
                                       </div>
                                       <div class="col-md-6 ">
                                          <span class="badge" style="color: white;border-radius: 4px;background: #212121;font-weight: 400;float: right;margin-top: 7px;" data-toggle="modal" data-target="#personaddon{{$item1['package_id']}}">Add Person</span>
                                       </div>
                                    </div>
                                    <ul class=" list-part mt-2" id="listhtml{{$item1['package_id']}}">
                                          @if(!empty($item1->addonperson[0]))
                                          @foreach($item1->addonperson as $key => $item)
                                          <li class="list-group-item">
                                             <label>{{$key+1}}. {{$item->person_first_name.' '.$item->person_last_name}}</label>  <span ><i style="float: right;" class="fa fa-trash" onclick="removePerson(<?php echo $item->id; ?>,<?php echo $item1['package_id']; ?>)"></i></span>
                                          </li>
                                          @endforeach
                                          @else
                                          <li class="list-group-item" style="text-align: center;">
                                             <label>No Person Added!</label>
                                          </li>
                                          @endif
                                    </ul>
                                 </div>
                                 @endif
                              @endif
                              
                           </div>
                           @endforeach
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
                        @if(!empty($data[0]['categorydata']))
                        <div class="row">
                           <div class="col-md-12">
                              <input type="submit" class="btn-send" value="Continue To Payment">
                           </div>
                        </div>
                        @endif
                     </div>
                  </div>
               </form>
               <!-- model -->
               @foreach($data as $key1 => $item1)
               <div class="modal fade personmodal" id="addsportModal{{$item1['package_id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
                  <div class="modal-dialog" style="margin-top: 12%;max-width: 50%!important;" >
                     <div class="modal-content" style="background-color: #323232 !important;">
                        <div class="modal-header" >
                           <h5 class="modal-title" id="myModalLabel" style="padding-bottom: 0px !important;"><label>{{$item1->packagedata->title}}</label> </h5>
                           <button type="button" class="close btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="container">
                              <form role="form" method="POST">
                              @csrf
                                 <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                       <div class="row">
                                          <div class="col-md-12">
                                             <div class="select_port pt-0">
                                                <ul>
                                                   @foreach($service_category as $key4 => $item4)
                                                   <li>
                                                      <input type="checkbox" name="category_data[{{$key4}}][id]" class="check selected_category{{$item1['package_id']}}" value="{{$item4->id}}" id="myCheckbox{{$item1['package_id'].''.$item4->id}}" <?php if(in_array(($item4->id), $item1['categoryids'] )){echo "checked";} ?>>
                                                      <label for="myCheckbox{{$item1['package_id'].''.$item4->id}}">
                                                         <img style="border-radius: 54%;height: 64px !important;width: 64px !important;" src="{{asset($item4->image)}}">
                                                      </label>
                                                      {{$item4->title}}
                                                   </li>
                                                   @endforeach
                                                </ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <p id="errorText" style="color:white;"></p>
                           <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                           <button type="button" class="btn btn-sm btn-secondary" onclick="addSport(<?php echo $item1['package_id'];?>,<?php echo $item1['id']; ?>);">Add</button>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
               <!-- model -->
               <!-- model -->
               @if(!empty($data[0]['categorydata']))
               @foreach($data as $key1 => $item1)
               @if($item1->packagedata['addon_adult_count'] > 0 || $item1->packagedata['addon_kid_count'] > 0 )
               <div class="modal fade personmodal" id="personaddon{{$item1['package_id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
                  <div class="modal-dialog" style="margin-top: 12%;max-width: 50%!important;" >
                     <div class="modal-content">
                        <div class="modal-header" >
                           <h5 class="modal-title" id="myModalLabel" style="padding-bottom: 0px !important;">Person Details</h5>
                           <button type="button" class="close btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="cont_sec" style="padding: 20px !important;border: 0px solid #707070 !important;">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <input id="person_package_id" type="hidden" name="person_package_id" value="{{$item1['package_id']}}" class="form-control" >
                                       <input id="person_package_id" type="hidden" name="cart_id" value="{{$item1['id']}}" class="form-control" >
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
                                       <input id="dob" type="text" name="dob" onchange="checkPersonType();"  class="form-control" placeholder="dd-mm-yyyy" required="required" autocomplete="off">
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
                                       <select name="weight_type" id="weight_type" required class="one mb-0 mt-0" id="weight_type">
                                          <option value="Kilogram" selected>Kilogram</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <h6 class="hgt_sec">Weight </h6>
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
                                       <select name="height_type" id="height_type" required  class="one mb-0 mt-0" id="height_type">
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
                           <button type="button" class="btn btn-sm btn-secondary" onclick="addPerson(<?php echo $item1['package_id'];?>,<?php echo $item1['id']; ?>);">Add</button>
                        </div>
                     </div>
                  </div>
               </div>
               @endif
               @endforeach
               @endif
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
   $(document).ready(function(){
      var data_count = '<?php echo count($data); ?>';
      for (let i = 1; i <= data_count; i++) {
         // $(document).on('change','.rearrange', function() {  
         var target = $('#sort_menu'+i);
         $('#sort_menu'+i).sortable({
            //   handle: '.rearrange',
            //   placeholder: 'highlight',
            //   axis: "y",
            update: function (e, ui){
               var itemid = $(this).data("sort_menu_id");
               var id = ui.item.attr("data-id");
               var sortData = $('#sort_menu'+i).sortable('toArray',{ attribute: 'data-id'});
               var newArray = sortData.filter(function(v){return v!==''});
               updateToDatabase(itemid,newArray)
            }
         })
         // })
      }
   
   })
   // $(document).sortable('div[id^="sort_menu"]', function() {  
   //     var itemid = this.value;
   //     console.log(itemid);
   // })
   
   function updateToDatabase(itemid, idString){
      var item_id = itemid;
      // var item_id = $("#item_id").val();
      var user_id = $("#user_id").val();
      $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});
      
      $.ajax({
            url:'{{url("update-order")}}',
            method:'POST',
            data:{
               item_id:item_id,
               ids:idString
            },
            success:function(){
               console.log('Successfully updated');
            }
         })
   }
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
   function addPerson(package_id,cart_id) {
      
      var order_id = $("#order_id").val();
      var addon_type = $("#addon_type").val();
      var user_id = $("#user_id").val();
      var package_id = package_id;
      var cart_id = cart_id;
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
      
      var weight_type = $("#weight_type").val();
      var height_type = $("#height_type").val();
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
              'cart_id':cart_id,
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
              'weight_type':weight_type,
              'height_type':height_type,
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
                  $.each(data.data, function (key, value) {
                     var key1 = key + parseInt(1);
                     $("#listhtml"+package_id).append('<li class="list-group-item"><label>'+(key1)+'. '+value.person_first_name+' '+value.person_last_name+'</label>  <span ><i style="float: right;" class="fa fa-trash" onclick="removePerson('+value.id+','+cart_id+')"></i></span></li>');
                  });
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
   function removePerson(id,package_id,cart_id) {
      if (!confirm('Are you sure you want to delete this?')) {
         return false;
      }
      var user_id = $("#user_id").val();
      var package_id = package_id;
      var cart_id = cart_id;
      var order_id = $("#order_id").val();
      $.ajax({
           url: "{{url('removePerson')}}",
           type: 'post',
           dataType: 'json',
           data: {
              'id':id,
              'user_id':user_id,
              'order_id':order_id,
              'package_id':package_id,
              'cart_id':cart_id,
           },
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           success: function(data){
               if (data.statusCode == "200") {
                  toastr.success(data.message);
                  $("#listhtml"+package_id).empty();
                  $.each(data.data, function (key, value) {
                     var key1 = key + parseInt(1);
                     $("#listhtml"+package_id).append('<li class="list-group-item"><label>'+(key1)+'. '+value.person_first_name+' '+value.person_last_name+'</label>  <span ><i style="float: right;" class="fa fa-trash" onclick="removePerson('+value.id+','+package_id+')"></i></span></li>');
                  });
                  // location.reload(true);
               }else{
                  toastr.error(data.message);
               }
            },
            error: function(){
               
            }
       });
   }

   function addSport(package_id,cart_id) {
      var category_id = [];
      $(".selected_category"+package_id+":checkbox:checked").each(function() {
            category_id.push($(this).val());
      });
      console.log(category_id.length);
      console.log(category_id);
      if (category_id.length < 1) {
         toastr.error("Please Select Any Sport")
         return false;
      }
      var order_id = $("#order_id").val();
      var user_id = $("#user_id").val();
      var package_id = package_id;
      var cart_id = cart_id;
      var check = check;
       $.ajax({
           url: "{{url('addsport')}}",
           type: 'post',
           dataType: 'json',
           data: {
              'order_id':order_id,
              'user_id':user_id,
              'package_id':package_id,
              'cart_id':cart_id,
              'check':check,
              'category_id':category_id,
           },
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           success: function(data){
            if (data.statusCode == "200") {
                  $('.personmodal').hide();
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
   
</script>
@endsection