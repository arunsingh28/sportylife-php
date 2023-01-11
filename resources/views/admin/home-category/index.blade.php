@inject('Roles', 'App\Models\Roles')
<?php @$roles_data = $Roles->where('id', auth()->user()->role_id)->first();?>
@extends('admin.layouts.main')
@section('breadcrumb')
Home Category
@endsection
@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Home Category List </h3>
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
                     <th>Title</th>
                     <th>Image</th>
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
                        @if($item->image != NULL)
                             <a href="{{ asset($item->image ?? '') }}" class="ply-btn" data-id="{{ $item->id ?? '' }}">
                                <img alt="Image placeholder" src="{{asset($item->image)}}" height="50">
                             </a>
                        @else
                             <span style="color:red;">Not Image Uploaded!</span>
                        @endif
                     </td>
                     
                     <td>
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10" || $roles_data->type == "new")
                        <a href="{{url('/admin/home-category-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
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
@endsection
