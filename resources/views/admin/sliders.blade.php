@extends('admin.layouts.main')
@section('breadcrumb')
Sliders
@endsection
@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Sliders List </h3>
               </div>
               <div class="col-4 text-right">
                  @if(auth()->user()->role_id == "1"  || auth()->user()->role_id == "10") 
                  <a href="{{route('slider-add')}}" class="btn btn-sm btn-default float-right">Add</a>
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
                     <th>Slider Serial No.</th>
                     <th>Image</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody class="list">
                   <?php $i = 1;?>
                   @foreach($sliders as $key => $item )
                  <tr>
                     <th>
                        {{$i}}
                     </th>
                     <td>
                        {{$item->title}}
                     </td>
                     <td>
                        {{$item->position}}
                     </td>
                     <td>
                        @if($item->image != NULL)
                             <a href="{{ asset($item->image ?? '') }}" class="ply-btn" data-id="{{ $item->id ?? '' }}">
                                <img alt="Image placeholder" src="{{asset($item->image)}}" height="50">
                             </a>
                        @else
                             <a href="{{ asset('uploads/images/demo-logo.png') }}" class="ply-btn" data-id="{{ $item->id ?? '' }}">
                                <img alt="Image placeholder" src="{{asset('uploads/images/demo-logo.png')}}" height="50">
                             </a>
                        @endif
                     </td>
                     <td>
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10")
                         <label class="switch">
                            <input type="checkbox" class="changestatus" data-id="{{$item->id}}" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                        @endif
                     </td>
                     <td>
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10")
                        <a href="{{url('/admin/slider-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "10")
                        <a href="{{url('/admin/slider-view',$item->id)}}" class="btn btn-sm btn-success">View</a>
                        <a href="{{url('/admin/slider-delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
                     
                        @endif
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
            url: '{{url("/admin/changeSliderStatus")}}',
            data: {'status': status, 'id': id},
            success: function(data){
                console.log(data.success)
            }
        });
    })
})
</script>
@endsection
