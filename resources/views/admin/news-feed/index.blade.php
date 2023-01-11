@extends('admin.layouts.main')
@section('breadcrumb')
News Feed
@endsection
@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">News Feed's List </h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('news-feed-add')}}" class="btn btn-sm btn-default float-right">Add</a>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush" id="myTable">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>Title</th>
                     <th>Upload Type</th>
                     <th>Uploads</th>
                     <th>Likes</th>
                     <th>Views</th>
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
                        {{$item->title}}
                     </td>
                     <td>
                        {{ucfirst($item->type)}}
                     </td>

                     <td>
                        @if($item->type == 'image')
                             <a href="{{ asset($item->uploads ?? '') }}" class="ply-btn" data-id="{{ $item->id ?? '' }}">
                            <img alt="{{$item->title}}" src="{{asset($item->uploads)}}" height="50">
                             </a>
                        @else
                             <a href="{{ asset($item->uploads ?? '') }}" class="ply-btn" data-id="{{ $item->id ?? '' }}">
                             <img alt="{{$item->title}}" src="{{asset($item->thumbnail)}}" height="50">
                             </a>
                        @endif
                     </td>
                     <td>
                        {{$item->like_count}}
                     </td>
                     
                     <td>
                        {{$item->view_count}}
                     </td>
                     <td>
                         <label class="switch">
                            <input type="checkbox" class="changestatus" data-id="{{$item->id}}" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                     </td>
                     <td>
                        <a href="{{url('/admin/news-feed-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="{{url('/admin/news-feed-delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
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
            url: '{{url("/admin/change-news-feed-status")}}',
            data: {'status': status, 'id': id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
</script>
@endsection
