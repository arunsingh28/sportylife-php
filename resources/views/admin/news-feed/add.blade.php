@extends('admin.layouts.main')
@section('breadcrumb')
News Feed Add
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">News Feed Add</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('news-feed')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('news-feed-add')}}" enctype="multipart/form-data">
               @csrf
               <h6 class="heading-small text-muted mb-4">News Feed information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="text" id ="title" name="title"  class="form-control" placeholder="Title" required>
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
                     
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Upload Type</label>
                           <select name="type" id="" class="form-control" onchange="showDiv(this)" required>
                              <option value="image">Image</option>
                              <option value="video">Video</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Uploads</label>
                           <input type="file" class="form-control" id="image" name="uploadimage" accept="image/*" required>
                           <input type="file" style="display:none" class="form-control" id="video" name="uploadvideo" accept="video/*">
                           <span>Image Size should be 620px*350px</span>
                        </div>
                     </div>
                    
                     
                  </div>
                  
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Description</label>
                           <textarea type="text" id="editor1" name="description" cols="5" rows="5" class="form-control" placeholder="Enter Description" required></textarea>
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
@section("script")

@endsection
