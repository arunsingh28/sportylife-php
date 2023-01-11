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
                <h2>Contact Us</h2>
                <h5> <b> How can we help </b> Send us a message! </h5>
                <div class="cont_sec">
                    <form role="form" method="POST" action="{{ route('web.contact-us') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">                
                                    <input id="name" type="text" name="name" class="form-control" placeholder="Enter Name" required="required">                         
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">                
                                    <input id="phone" type="text" name="phone" class="form-control" placeholder="Enter Mobile" required="required">                         
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">                
                                    <input id="subject" type="text" name="subject" class="form-control" placeholder="Subject" required="required">                         
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">                
                                    <textarea id="msg" style="border-radius: 15px;" name="description" class="form-control" placeholder="Description" rows="5" required=""></textarea>
                                </div>
                            </div>
                           
                            <div class="col-md-12">
                                <input type="submit" class="btn-send" value="Submit">
                            </div>
                            <span class="mt-2" style="color:#fff;text-align:center;">Or write us at <a href="mailto:someone@example.com">support@sportylife.in</a></span>
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
     $(document).ready(function () {  
            $("#subject").keyup(function () {  
                $('#subject').css('textTransform', 'uppercase');  
            });  
        });  
</script>
@endsection