@inject('Roles', 'App\Models\Roles')
<?php @$roles_data = $Roles->where('id', auth()->user()->role_id)->first();?>
@extends('admin.layouts.main')
@section('breadcrumb')
    User's FRC
@endsection
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">User's FRC  </h3>
                        <h3 id="upload_text_div"></h3>
                    </div>
                    <div class="col-4 text-right">
                        <!-- <a href="{{route('nutrition-diet-add')}}" class="btn btn-sm btn-default float-right">Add</a> -->
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush" id="myTable">
                    
                    <thead class="thead-light">
                        <tr>
                            <th>Sr. No</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        <?php $i = 1; ?>
                        @foreach($data as $key => $item )
                        <tr>
                            <th>
                                {{$i}}
                            </th>
                            <td>
                                {{$item->first_name ? @$item->first_name.' '.@$item->last_name :  @$item->name}}
                            </td>
                            <td>
                                {{$item->email ? $item->email : 'N/A'}}
                            </td>
                            <td>
                                <div class="row">
                                    @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3" || auth()->user()->role_id == "10" || $roles_data->type == "new")
                                        @if($item->frc_pdf != NULL)
                                        <div class="col-md-2 mr-0">
                                            <a href="{{ asset($item->frc_pdf ?? '') }}" target="_blank">
                                                <img src="{{asset('web/assets/img/doc-sample1.png')}}" height="30" alt="" title="click to view">
                                            </a>
                                        
                                            <i class="fa fa-trash ml-2" style="font-size: 20px;color: #d84032;margin-top: 5px;position: absolute;" title="Remove" onclick="removeattachment(<?php echo $item->id; ?>);" data-id="{{$item->id}}"></i>
                                        </div>
                                        @endif
                                    @endif
                                    @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3"|| auth()->user()->role_id == "10" || $roles_data->type == "new")
                                    <div class="col-md-10">
                                        @if(auth()->user()->role_id != "3")
                                        <label style="color:black;" for="attachment{{$item->id}}" >Attach document </label>
                                        <input type="file" style="display: none;" onchange="attachment_upload(<?php echo $item->id; ?>);" id="attachment{{$item->id}}" name="attachment" data-id="{{$item->id}}" value="" class="form-control attachment_upload" title="Upload">&nbsp;|
                                        @endif
                                        <a href="{{url('/admin/users-frc-view',$item->id)}}" class="btn btn-sm btn-primary ml-3">View</a>
                                        <a href="{{url('/admin/users-frc-share',$item->id)}}" class="btn btn-sm btn-default">Share By Email</a>
                                    </div>
                                    @endif
                                </div>
                                
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function attachment_upload(id) {
        // console.log("!23");
        // e.preventDefault();
        var id = $('#attachment'+id).attr("data-id");
        var file = $('#attachment'+id)[0].files[0];
        var formdata = new FormData(); 
        formdata.append('file', file);
        formdata.append('id',id);
        $.ajax({
        type: "POST",
        dataType: "json",
        url: '{{url("/admin/attachmentupload")}}',
        data: formdata,
        // data: {'id': id},
        contentType: false,
        processData: false,
        success: function(data){
            // console.log(data.success)
            $('#upload_text_div').empty();
            if (data.statusCode == 200) {
                $('#upload_text_div').append(data.message).css("color","green");
            }else{
                $('#upload_text_div').append(data.message).css("color","red");
            }
            // setInterval(fetchdata,5000);
            setInterval(function(){ 
                window.location.href = "{{route('users-frc')}}";
            },1000);

        }
        });
    }
    function removeattachment(id) {
        if (!confirm("Are you sure to remove this?")) {
            return false;
        }
        // console.log("!23");
        // e.preventDefault();
        var id = $('#attachment'+id).attr("data-id");
        var formdata = new FormData(); 
        formdata.append('id',id);
        $.ajax({
        type: "POST",
        dataType: "json",
        url: '{{url("/admin/removeattachment")}}',
        data: formdata,
        // data: {'id': id},
        contentType: false,
        processData: false,
        success: function(data){
            // console.log(data.success)
            $('#upload_text_div').empty();
            if (data.statusCode == 200) {
                $('#upload_text_div').append(data.message).css("color","green");
            }else{
                $('#upload_text_div').append(data.message).css("color","red");
            }
            // setInterval(fetchdata,5000);
            setInterval(function(){ 
                window.location.href = "{{route('users-frc')}}";
            },1000);

        }
        });
    }
</script>
@endsection
