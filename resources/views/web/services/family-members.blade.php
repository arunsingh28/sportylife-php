@extends('layouts.main')
@section('style')
<style>
   @media screen and (max-width: 768px) {
   }
   .profile-img {
   width: 150px;
   border-radius: 120px;
   margin: auto auto 15px;
   height: 150px;
   }
   .profile-img img {
   border-radius: 120px;
   }
   .profile-name{
   text-align: center;
   color: #fff;
   margin: 10px 0;
   font-size: 20px;
   }
   .profile-name{
   margin-bottom: 0;
   }
   .login-btn-user{
   padding: 5px 50px !important;
   }
   .fa-arrow-right-to-bracket:before, .fa-sign-in:hover {
   content: "\f090";
   color: #ef4234;
   }
   .font-14{
   font-size:14px;
   }
   .family-img{
   height: 100%;
   object-fit: cover;
   }


</style>
@endsection
@section('content')
<!-- <div id="page">
   <img class="loader" src="{{asset('web/assets/img/loader.gif')}}" alt="" class="img-fluid">
</div> -->
<!-- <div id="loading">
    <div class="loader-gif-img">
        <img src="{{asset('web/assets/img/loader.gif')}}" alt="">
    </div>
</div> -->
<div class="invite_friend">
   <div class="container">
      <h2> My Family </h2>
      @if(!empty($addon_users[0]))
      <div class="row ">
         @foreach($addon_users as $key => $item)
         <div class="col-md-4">
            <div class="invite_friend_inner w-100 mt-2">
               <div class="member-image p-0">
                  <div class="profile-img mt-2">
                     @if($item->image != NULL) 
                     <img class="w-100 family-img"  src="{{asset($item->image)}}">
                     @else
                     <img class="w-100 family-img"  src="{{asset('uploads/images/dummy_male.png')}}">
                     @endif
                  </div>
                  <div class="profile-name">
                     <h4 class="m-0" style="font-size:22px;"> {{$item->first_name}} </h4>
                     <p class="font-14"> {{$item->email}} </p>
                  </div>
               </div>
               <!-- <input type="hidden" name="id" id="id" value="{{$item->id}}">
                  <input type="hidden" name="email" id="email" value="{{$item->email}}">
                  <input type="hidden" name="login_type" id="login_type" value="sub_user">
                  <div class="member-button">
                      <div class="get_code">
                          <button class="w3-btn w3-teal login-btn-user" style="margin-bottom: 14px;" >  <i class="fa fa-sign-in "></i></button>
                      </div>
                  </div> -->
            </div>
         </div>
         @endforeach
      </div>
      @else
      <h4 style="text-align: center;">No User Added!</h4>
      @endif
   </div>
</div>
@endsection
@section('script')
<script>
   function login() {
       var id = $('#id').val();
       var email = $('#email').val();
       var login_type = $('#login_type').val();
       $.ajax({
       url: "{{url('login')}}",
       type: 'post',
       dataType: 'json',
       data: {
           'id':id,
           'email':email,
           'login_type':login_type,
       },
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(data){
           if (data.statusCode == "200") {
           window.location.href = "{{url('/index')}}";
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