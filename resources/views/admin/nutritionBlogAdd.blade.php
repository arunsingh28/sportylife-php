@extends('admin.layouts.main')
@section('breadcrumb')
Nutrition Blog Add
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Nutrition Blog Add</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('nutrition-blogs')}}" class="btn btn-sm btn-default">List</a>
               </div>
            </div>
         </div>
         <div class="card-body">
            <form method="post" action="{{route('nutrition-blog-add')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Nutrition Blog information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="text" name="title"  class="form-control" placeholder="Title" required>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Image</label>
                           <input type="file" class="form-control" name="image" accept="image/*" required>
                           <span>Image Size should be 625px*450px</span>
                        </div>
                     </div>
                  </div>
                
                  <div class="row">
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
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Description</label>
                           <textarea type="text" id="editor1" name="description" cols="6" rows="10" class="form-control" placeholder="Enter Description" required></textarea>
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