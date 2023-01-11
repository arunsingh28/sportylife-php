@extends('admin.layouts.main')
@section('breadcrumb')
Nutrition Blogs
@endsection
@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Nutrition Blog's List </h3>
               </div>
               <div class="col-4 text-right">
                  @if(auth()->user()->role_id == "1"  || auth()->user()->role_id == "10") 
                  <a href="{{route('nutrition-blog-add')}}" class="btn btn-sm btn-default float-right">Add</a>
                  @endif
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush" id="myTable">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>Title</th>
                     <th>Image</th>
                     <th>Views</th>
                     <th>Likes</th>
                     <th>Share</th>
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
                        <!-- {{$item->title}} -->
                        {!! \Str::limit($item->title, 50, $end='...') !!}
                     </td>

                     <td>
                        @if($item->image != NULL)
                             <a href="{{ asset($item->image ?? '') }}" class="ply-btn" data-id="{{ $item->id ?? '' }}">
                                <img alt="Image placeholder" src="{{asset($item->image)}}" height="50">
                             </a>
                        @else
                        N/A
                        @endif
                     </td>
                     <td>
                        {{$item->view_count}}
                     </td>
                     <td>
                        {{$item->like_count}}
                     </td>
                     <td>
                        {{$item->share_count}}
                     </td>
                     <td>
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4"|| auth()->user()->role_id == "10") 
                         <label class="switch">
                            <input type="checkbox" class="changestatus" data-id="{{$item->id}}" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                        @endif
                     </td>
                     <td>
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4"|| auth()->user()->role_id == "10") 
                        <a href="{{url('/admin/nutrition-blog-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "10") 
                        <a href="{{url('/admin/nutrition-blog-delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
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
            url: '{{url("/admin/changeNutritionBlogStatus")}}',
            data: {'status': status, 'id': id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
</script>
@endsection
