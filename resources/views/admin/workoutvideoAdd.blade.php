@extends('admin.layouts.main')
@section('breadcrumb')
Workout Video Add
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Workout Video Add</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('workoutvideos')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('workout-video-add')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">FAQ information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Category</label>
                           <select name="category_id" id="" class="form-control" required> 
                                <option value="">Select Option</option>
                                @foreach($workoutcate as $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                           </select>
                        </div>
                     </div>
                     
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="text" name="title" class="form-control" placeholder="Enter Title" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Video</label>
                           <div class="custom-file">
                                <input type="file" name="video" class="custom-file-input" id="customFileLang" accept="video/*">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                            </div>
                        </div>
                     </div>

                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <select name="status" class="form-control" required>
                               <option value="">Select Option</option>
                               <option value="1">Active</option>
                               <option value="0">Inactive</option>
                           </select>
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