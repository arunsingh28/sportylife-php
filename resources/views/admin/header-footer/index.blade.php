@inject('Roles', 'App\Models\Roles')
<?php @$roles_data = $Roles->where('id', auth()->user()->role_id)->first();?>
@extends('admin.layouts.main')
@section('breadcrumb')
Header & Footer
@endsection
@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Header & Footer List </h3>
               </div>
               <div class="col-4 text-right">
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush" id="myTable">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>Type</th>
                     <th>Title</th>
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
                        {{ucfirst($item->type)}}
                     </td>
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
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10" || $roles_data->type == "new")
                        <a href="{{url('/admin/header-footer-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
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
            url: '{{url("/admin/changeheaderFooterStatus")}}',
            data: {'status': status, 'id': id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
</script>
@endsection
