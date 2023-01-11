@extends('admin.layouts.main')
@section('breadcrumb')
Contact Us
@endsection
@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Enquiry List </h3>
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
                     <th>User</th>
                     <th>Subject</th>
                     <th>Description</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody class="list">
                   <?php $i = 1;?>
                   @foreach($contactus as $key => $item )
                  <tr>
                     <th>
                        {{$i}}
                     </th>
                     <td>
                        {{$item->userdata->name ?? 'User'}}
                    </td>
                    <td>
                        {{ \Str::limit($item->subject, 50, $end='...') }}
                    </td>
                    <td>
                        {{ \Str::limit($item->description, 50, $end='...') }}
                    </td>
                    <td>
                        {{ucfirst($item->status)}}
                     </td>
                     <td>
                        @if($item->status == "pending")
                           @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10")
                           <a href="{{url('/admin/contact-us-reply',$item->id)}}" class="btn btn-sm btn-primary">Reply</a>
                           @endif
                        @else
                           @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "10")
                           <a href="{{url('/admin/contact-us-view',$item->id)}}" class="btn btn-sm btn-success">View</a>
                           @endif
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "10")
                         <a href="{{url('/admin/contact-us-delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
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