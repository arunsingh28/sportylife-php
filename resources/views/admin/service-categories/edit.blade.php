@extends('admin.layouts.main')
@section('breadcrumb')
Sports Update
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Sports Update</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('service-categories')}}" class="btn btn-sm btn-default">List</a>
               </div>
            </div>
         </div>

         <div class="card-body">
             @if($errors->any())
                {!! implode('', $errors->all('
                    <div class="alert alert-warning" role="alert">
                        :message
                    </div>
                ')) !!}
            @endif
            <form method="post" action="{{route('service-category-update')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Sports information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="hidden" name="id" value="{{$data->id}}" >
                           <input type="text" name="title" value="{{$data->title}}" class="form-control" placeholder="Title" disabled>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Image</label>
                           <input type="file" class="form-control" name="image" accept="image/*">
                           <br>
                           <br>
                            <a href="{{ asset($data->image) }}" class="ply-btn" data-id="{{ $data->id }}"><img alt="Image placeholder" src="{{asset($data->image)}}" height="50"></a>
                        </div>
                     </div>
                  </div>

               </div>
               <hr class="my-4" />
               <button type="submit" class="btn btn-sm btn-default">Save</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
