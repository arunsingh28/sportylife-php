@extends('admin.layouts.main')
@section('breadcrumb')
    Notification Add
@endsection
@section('style')
    
    
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Notification Add</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('notifications')}}" class="btn btn-sm btn-default">List</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('
                            <div class="alert alert-warning" role="alert">
                                :message
                            </div>
                        ')) !!}
                    @endif
                    <form method="post" action="{{route('notifications-add')}}" enctype="multipart/form-data">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Notification information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Type</label>
                                        <select name="type" id="type" class="form-control js-example-basic-single" required>
                                            <option value="">Select Option</option>
                                            <option value="live_session">Live Sessions</option>
                                            <option value="language">Language</option>
                                            <option value="package">Package</option>
                                            <option value="all">All Users</option>
                                            <option value="individual_user">Individual User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="language_div" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-control-label">Select Language</label>
                                        <select name="language_id" id="language_id" class="form-control js-example-basic-single">
                                            <option value="">Select Option</option>
                                            @if(!empty($language[0]))
                                                @foreach($language as $key => $item)
                                                <option value="{{$item->id}}">{{$item->language_title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="package_div" style="display:none;"> 
                                    <div class="form-group">
                                        <label class="form-control-label">Select Package</label>
                                        <select name="package_id" id="package_id" class="form-control js-example-basic-single">
                                            <option value="">Select Option</option>
                                            @if(!empty($package[0]))
                                                @foreach($package as $key => $item)
                                                <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="user_div" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-control-label">Select User</label>
                                        <select name="user_id" id="user_id" class="form-control js-example-basic-single">
                                            <option value="">Select Option</option>
                                            @if(!empty($users[0]))
                                                @foreach($users as $key => $item)
                                                <option value="{{$item->id}}">{{$item->first_name ? ucfirst(@$item->first_name).' '.ucfirst(@$item->last_name) : $item->name }} ({{$item->email}})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>



                                
                                <div class="col-lg-6" id="live_session_cat_div" style="display:none;">
                                    <div class="form-group">
                                    <label class="form-control-label" >Live Sessions Category</label>
                                    <select name="live_session_cat" id="live_session_cat" class="form-control" required> 
                                            <option value="">Select Option</option>
                                            @foreach($workoutcate as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="user_type_div" style="display:none;">
                                    <div class="form-group">
                                    <label class="form-control-label" >User Type</label>
                                    <select name="user_type" id="user_type" class="form-control" required>
                                        <option value="">Select Option</option>
                                        <option value="adult">Adult</option>
                                        <option value="kid">Kid</option>
                                        <option value="sporty_kid">Sporty Kid</option>
                                    </select>
                                    </div>
                                </div>



                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="hidden" name="id"  class="form-control" value="">
                                        <label class="form-control-label">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                               required>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                               accept="image/*">
                                    </div>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Body</label>
                                        <textarea name="body" class="form-control" required cols="5" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4"/>
                        <button type="submit" class="btn btn-sm btn-default">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(function(){
        $("#type").change(function () { 
            var type = $("#type").val();
            if (type == "language") {
                $("#language_div").show();
                $("#package_div").hide();
                $("#user_div").hide();
                $("#user_type_div").hide();
                $("#live_session_cat_div").hide();

                $("#language_id").attr("required","required");
                $("#package_id").removeAttr("required");
                $("#user_id").removeAttr("required");
                $("#live_session_cat").removeAttr("required");
                $("#user_type").removeAttr("required");
            }else if(type == "package"){
                $("#language_div").hide();
                $("#package_div").show();
                $("#user_div").hide();
                $("#user_type_div").hide();
                $("#live_session_cat_div").hide();
                
                $("#package_id").attr("required","required");
                $("#language_id").removeAttr("required");
                $("#user_id").removeAttr("required");
                $("#live_session_cat").removeAttr("required");
                $("#user_type").removeAttr("required");
                
            }else if(type == "individual_user"){
                $("#language_div").hide();
                $("#package_div").hide();
                $("#user_div").show();
                $("#user_type_div").hide();
                $("#live_session_cat_div").hide();
                
                $("#user_id").attr("required","required");
                $("#package_id").removeAttr("required");
                $("#language_id").removeAttr("required");
                $("#live_session_cat").removeAttr("required");
                $("#user_type").removeAttr("required");
                
            }else if(type == "live_session"){
                $("#language_div").hide();
                $("#package_div").hide();
                $("#user_div").hide();
                $("#user_type_div").show();
                $("#live_session_cat_div").show();
                
                $("#user_type").attr("required","required");
                $("#live_session_cat").attr("required","required");
                $("#user_id").removeAttr("required");
                $("#package_id").removeAttr("required");
                $("#language_id").removeAttr("required");
                
                
            }else{
                $("#language_div").hide();
                $("#package_div").hide();
                $("#user_div").hide();
                $("#user_type_div").hide();
                $("#live_session_cat_div").hide();

                $("#language_id").removeAttr("required");
                $("#package_id").removeAttr("required");
                $("#user_id").removeAttr("required");
                $("#live_session_cat").removeAttr("required");
                $("#user_type").removeAttr("required");
            }
        });
    });
</script>
@endsection
