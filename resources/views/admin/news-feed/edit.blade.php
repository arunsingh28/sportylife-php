@extends('admin.layouts.main')
@section('breadcrumb')
News Feed 
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">News Feed Update</h3>
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
            <form method="post" action="{{route('news-feed-update')}}" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="id" value="{{$data->id}}">
               <h6 class="heading-small text-muted mb-4">News Feed information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="text" id ="title" name="title" value="{{$data->title}}"  class="form-control" placeholder="Title" required>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <select name="status" class="form-control" required>
                              <option value="">Select Option</option>
                              <option value="1" @if($data->status == '1') selected  @endif>Active</option>
                              <option value="0" @if($data->status == '0') selected  @endif>Inactive</option>
                           </select>
                        </div>
                     </div>
                     
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Upload Type</label>
                           <select name="type" id="" class="form-control" onchange="showDiv(this)" required>
                              <option value="image" <?php if($data->type == "image"){echo "selected";} ?>>Image</option>
                              <option value="video" <?php if($data->type == "video"){echo "selected";} ?>>Video</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Uploads</label>
                           @if($data->type == 'image')
                           <input type="file" class="form-control" id="image" name="uploadimage" accept="image/*">
                           <input type="file" style="display:none" class="form-control" id="video" name="uploadvideo" accept="video/*">
                           @else
                           <input type="file" style="display:none" class="form-control" id="image" name="uploadimage" accept="image/*">
                           <input type="file"  class="form-control" id="video" name="uploadvideo" accept="video/*">
                           @endif
                           <span>Image Size should be 620px*350px</span>
                           <br>
                           <br>
                           @if($data->type == 'image')
                               <img required disabled readonly alt="{{$data->title}}" src="{{asset($data->uploads)}}" height="50">
                            @else
                                <video width="200"  controls>
                                    <source src="{{asset($data->uploads)}}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Description</label>
                           <textarea type="text" id="editor1" name="description" cols="5" rows="5" class="form-control" placeholder="Enter Description" vlaue="{{$data->description}}" >{{$data->description}}</textarea>
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
