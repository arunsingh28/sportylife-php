@extends('admin.layouts.main')
@section('breadcrumb')
Invite History
@endsection
@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Invite History </h3>
               </div>
               <div class="col-4 text-right">
                  <!-- <a href="{{route('faq-category')}}" class="btn btn-sm btn-default float-right ml-2">FAQ's Category</a> -->
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush" id="myTable">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>Refer By</th>
                     <th>User Name</th>
                     <th>E-mail</th>
                     <th>Mobile</th>
                     <th>Date</th>
                  </tr>
               </thead>
               <tbody class="list">
                   <?php $i = 1;?>
                   @foreach($users as $key => $item )
                  <tr>
                     <th>
                        {{$i}}
                     </th>
                     <td>
                        {{$item->referbyuserdata->name ?? 'N/A'}}
                    </td>
                    <td>
                        {{$item->name ?? 'N/A'}}
                    </td>
                    <td>
                        {{$item->email}}
                    </td>
                    <td>
                        {{$item->phone}}
                     </td>
                    <td>
                        {{date("Y-m-d H:i:s", strtotime($item->created_at))}}
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