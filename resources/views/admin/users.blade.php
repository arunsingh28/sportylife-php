@extends('admin.layouts.main')
@section('breadcrumb')
Users
@endsection
@section('style')
<style>
   .fiterDiv {
   border: 0.5px solid #172b4d;
   padding: 5px;
   margin-top: 30px;
   border-radius: 10px;
   margin-bottom: 15px;
   /* box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px; */
   }
</style>
@endsection
@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Users List </h3>
               </div>
               <?php 
                  $role_arr = ['1', '10']; 
                  if (in_array(Auth::user()->role_id, $role_arr)) {
               ?>
               <div class="col-4 text-right">
                   <a href="{{asset('uploads/'.@$admin_data->userlist_crm_url.'')}}" target="_blank" class="btn btn-sm btn-default float-right">Export CRM</a>
                   <a href="{{asset('uploads/'.@$admin_data->userlist_lms_url.'')}}" target="_blank" class="btn btn-sm mr-2 btn-default float-right">Export LMS</a>
               </div>
               <?php } ?>
            </div>
            <form method="post" action="{{route('user-search')}}" enctype="multipart/form-data">
            @csrf
            <div class="fiterDiv">
               <h3 class="ml-3 mt-1">Filter <button class="btn btn-sm btn-default float-right mr-3 " type="submit"> Search </button> 
                  </h3>
                  <hr class="mt-0 mb-0 ml-3 mr-3">
                  <div class="row ">
                     <div class="col-lg-4 ml-3" >
                        <div class="form-group">
                           <label class="form-control-label">Language</label>
                           <select name="language_id" id="language_id" class="form-control-sm js-example-basic-single" >
                              <option value="">Select Option</option>
                              @if(!empty($language[0]))
                              @foreach($language as $key => $item)
                              <option value="{{$item->id}}" <?php if(!empty($language_id)){if($language_id == $item->id){echo "selected";}}?>>{{$item->language_title}}</option>
                              @endforeach
                              @endif
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-4 ml-3" >
                        <div class="form-group">
                           <label class="form-control-label">User Payment Status</label>
                           <select name="user_pay_type" id="user_pay_type" class="form-control-sm js-example-basic-single" >
                              <option value="">Select Option</option>
                              <option value="Paid" <?php if(!empty($user_pay_type)){if($user_pay_type == "Paid"){echo "selected";}}?>>Paid</option>
                              <option value="Unpaid" <?php if(!empty($user_pay_type)){if($user_pay_type == "Unpaid"){echo "selected";}}?>>Unpaid</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            </form>
         <div class="table-responsive">
            <table class="table align-items-center table-flush" id="myTable">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>Name</th>
                     <th>Language</th>
                     <th>Phone</th>
                     <th>Email</th>
                     <th>Image</th>
                     <th>User Payment Status</th>
                     <th>Status</th>
                     <th>Action</th>
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
                        {{$item->name}}
                     </td>
                     <td>
                        {{$item->languagedata->language_title ?? 'N/A'}}
                     </td>
                     <td>
                        {{$item->phone}}
                     </td>
                     <td>
                        {{$item->email}}
                     </td>
                     <td>
                        @if($item->image != NULL)
                             <a href="{{ asset($item->image ?? '') }}" class="ply-btn" data-id="{{ $item->id ?? '' }}">
                            <img alt="Image placeholder" src="{{asset($item->image)}}" height="50">
                             </a>
                        @else
                            <!-- <img alt="Image placeholder" src="{{asset('uploads/images/demo-logo.png')}}" height="50"> -->
                            N/A
                        @endif
                     </td>
                     <td>
                        {{$item->paid_status}}
                     </td>
                     <td>
                        <!-- @if($item->status == 1)
                        <button class="btn btn-sm btn-default">Active</button>
                        @else
                        <button class="btn btn-sm btn-danger">Block</button>
                        @endif -->
                        <!-- <input data-id="{{$item->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}> -->
                        <label class="switch">
                            <input type="checkbox" class="changestatus" data-id="{{$item->id}}" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                     </td>
                     <td>
                        {{-- @if($auth_user->roledata->type == "static" )
                        @endif --}}
                        <a href="{{url('/admin/user-view',$item->id)}}" class="btn btn-sm btn-success">View</a>
                        <!-- <a href="{{url('/admin/user-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a> -->
                        <a href="{{url('/admin/user-delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
                     </td>
                  </tr>
                  <?php $i++;?>
                  @endforeach
               </tbody>
            </table>
         </div>
         <!-- Card footer -->
         <!-- <div class="card-footer py-4">
            <nav aria-label="...">
               <ul class="pagination justify-content-end mb-0">
                  <li class="page-item disabled">
                     <a class="page-link" href="#" tabindex="-1">
                     <i class="fas fa-angle-left"></i>
                     <span class="sr-only">Previous</span>
                     </a>
                  </li>
                  <li class="page-item active">
                     <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item">
                     <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                     <a class="page-link" href="#">
                     <i class="fas fa-angle-right"></i>
                     <span class="sr-only">Next</span>
                     </a>
                  </li>
               </ul>
            </nav>
         </div> -->
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
            url: '{{url("/admin/changeUserStatus")}}',
            data: {'status': status, 'id': id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
</script>
@endsection
