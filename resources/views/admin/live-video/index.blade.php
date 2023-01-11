@inject('Roles', 'App\Models\Roles')
<?php @$roles_data = $Roles->where('id', auth()->user()->role_id)->first();?>
@extends('admin.layouts.main')
@section('breadcrumb')
Live Video
@endsection

@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Live Video's List </h3>
               </div>
               <div class="col-4 text-right">
                  @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "10" || $roles_data->type == "new") 
                  <a href="{{route('live-video-add')}}" class="btn btn-sm btn-default float-right">Add</a>
                  @endif
               </div>  
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush" id="myTable">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>User Type</th>
                     <th>Category</th>
                     <th>Title</th>
                     <th>Video(Thumbnail)</th>
                     <th>Start Date & Time</th>
                     <th>Total Joiners</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody class="list">
                   <?php $i = 1;?>
                   @foreach($data as $key => $item )
                  <tr>
                     <th>
                        {{$i}}
                     </th>
                     <td>
                        {{ucfirst($item->user_type)}}
                     </td>
                     <td>
                        {{$item->workoutcategorydata->title}}
                     </td>
                     <td>
                        {{$item->title ?? 'N/A'}}
                     </td>
                     <td>
                        @if($item->thumbnail != NULL)
                             <a href="{{ asset($item->video) }}" class="ply-btn-video" data-id="{{ $item->id }}"><img src="{{ asset($item->thumbnail) }}" alt="" height="50"></a>
                        @else
                            N/A
                        @endif
                     </td>
                     <td>
                        {{date('l, d-M-Y, H:i', strtotime($item->start_date_time))}}
                     </td>
                     <td>{{$item->total_joiners}}</td>
                     <td>
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "5" || auth()->user()->role_id == "10" || $roles_data->type == "new")
                        <label class="switch">
                            <input type="checkbox" class="changestatus" data-id="{{$item->id}}" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                        @endif
                     </td>
                     <td>
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "5" || auth()->user()->role_id == "10" || $roles_data->type == "new")
                        <a href="{{url('/admin/live-video-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "10" || $roles_data->type == "new")
                        <a href="{{url('/admin/live-video-delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
                        @endif
                     </td>
                  </tr>
                  <?php $i++;?>
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
$(function() {
    $('#myTable').on('change', 'tbody input.changestatus', function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{url("/admin/changeLiveVideoStatus")}}',
            data: {'status': status, 'id': id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
</script>
@endsection
