@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="contact_start">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-0">
            </div>
            <div class="col-lg-6 col-md-12">
                <h2>Change Password</h2>
                <div class="cont_sec">
                    <form role="form" method="POST" action="{{ route('web.update-password') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12"> 
                                <div class="form-group">                
                                    <input id="current_password" type="password" name="current_password" class="form-control" placeholder="Current Password" required="required" autocomplete="off" >                                   
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group" style="position: relative;">                
                                    <input id="password" type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"  class="form-control" placeholder="New Password" required="required" autocomplete="off" >                      
                                    <h6 class="kg"  onclick="showpassword()" id="eyeopt" style="top: 8px !important;"><i  class="fa fa-eye-slash" style="margin-left: 32%;"></i></h6>             
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" style="position: relative;">                
                                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password" required="required" autocomplete="off" >
                                    <h6 class="kg"  onclick="showconfirmpassword()" id="eyeoptchange" style="top: 8px !important;"><i  class="fa fa-eye-slash" style="margin-left: 32%;"></i></h6>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <input type="submit" class="btn-send" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-0">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
        function showpassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
               x.type = "text";
               $("#eyeopt").html("<i class='fa fa-eye' style='margin-left: 32%;'></i>")
            } else {
               x.type = "password";
               $("#eyeopt").html("<i class='fa fa-eye-slash' style='margin-left: 32%;'></i>")
            }
         }
         
         function showconfirmpassword() {
            var x = document.getElementById("password_confirmation");
            if (x.type === "password") {
               x.type = "text";
               $("#eyeoptchange").html("<i class='fa fa-eye' style='margin-left: 32%;'></i>")
            } else {
               x.type = "password";
               $("#eyeoptchange").html("<i class='fa fa-eye-slash' style='margin-left: 32%;'></i>")
            }
         }
</script>
@endsection