@extends('admin.layouts.main')
@section('breadcrumb')
Workout Category
@endsection
@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Workout Category List </h3>
               </div>
               <div class="col-4 text-right">
                  <!-- <a href="{{route('faq-category')}}" class="btn btn-sm btn-default float-right ml-2">FAQ's Category</a> -->
                  <a href="{{route('workout-category-add')}}" class="btn btn-sm btn-default float-right">Add</a>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush" id="myTable">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>Title</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody class="list">
                   <?php $i = 1;?>
                   @foreach($workoutcats as $key => $item )
                  <tr>
                     <th>
                        {{$i}}
                     </th>
                     <td>
                        {{$item->title}}
                     </td>
                     <td>
                        <label class="switch">
                            <input type="checkbox" class="changestatus" data-id="{{$item->id}}" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                     </td>
                     <td>
                        <a href="{{url('/admin/workout-category-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="{{url('/admin/workout-category-delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
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
            url: '{{url("/admin/changeWorkoutCategoryStatus")}}',
            data: {'status': status, 'id': id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
</script>
@endsection