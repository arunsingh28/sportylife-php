@extends('admin.layouts.main')
@section('breadcrumb')
Workout Video
@endsection

@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Workout Video's List </h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('workout-category')}}" class="btn btn-sm btn-default float-right ml-2">Workout Video Category</a>
                  @if(auth()->user()->role_id == "1") 
                  <a href="{{route('workout-video-add')}}" class="btn btn-sm btn-default float-right">Add</a>
                  @endif
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush" id="myTable">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>Category</th>
                     <th>Title</th>
                     <th>Video(Thumbnail)</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody class="list">
                   <?php $i = 1;?>
                   @foreach($workoutvideos as $key => $item )
                  <tr>
                     <th>
                        {{$i}}
                     </th>
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
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "5" || auth()->user()->role_id == "10")
                        <label class="switch">
                            <input type="checkbox" class="changestatus" data-id="{{$item->id}}" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                        @endif
                     </td>
                     <td>
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "5" || auth()->user()->role_id == "10")
                        <a href="{{url('/admin/workout-video-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "10")
                        <a href="{{url('/admin/workout-video-delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
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
            url: '{{url("/admin/changeWorkoutStatus")}}',
            data: {'status': status, 'id': id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
</script>
@endsection
