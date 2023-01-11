@extends('admin.layouts.main')
@section('breadcrumb')
Workout Category Update
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Workout Category Update</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('workout-category')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('workout-category-update')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Category information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="hidden" name="id" class="form-control" value="{{$workoutcat->id}}">
                           <input type="text" name="title" class="form-control" value="{{$workoutcat->title}}" placeholder="Enter Title" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <select name="status" class="form-control" required>
                               <option value="1" <?php if($workoutcat->status == '1'){echo "selected";} ?>>Active</option>
                               <option value="0" <?php if($workoutcat->status == '0'){echo "selected";} ?>>Inactive</option>
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