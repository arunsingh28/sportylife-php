@extends('admin.layouts.main')
@section('breadcrumb')
Settings
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">{{ucfirst($setting->title)}} Update</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('settings')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('setting-update')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">{{$setting->title}} information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="hidden" name="id" value="{{$setting->id}}" class="form-control">
                           <input type="hidden" name="type" value="{{$setting->type}}" class="form-control">
                           <input type="text" name="title" value="{{$setting->title}}" class="form-control" placeholder="Title" readonly>
                        </div>
                     </div>
                     @if($setting->type == "splash" )
                     <div class="col-lg-6">
                         <div class="form-group">
                             <label class="form-control-label" >Upload</label>
                            <div class="custom-file">
                                <input type="file" name="value" class="custom-file-input" id="customFileLang" accept="video/*">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                <br>
                                <!-- <img alt="Video" src="{{asset($setting->value)}}" height="50"> -->
                                <video width="200"  controls>
                                    <source src="{{asset($setting->value)}}" type="video/mp4">
                                    <!-- <source src="movie.ogg" type="video/ogg"> -->
                                </video>
                            </div>
                        </div>
                    </div>
                    
                    @elseif($setting->type == "profile_comming_soon_image" )
                     <div class="col-lg-6">
                         <div class="form-group">
                             <label class="form-control-label" >Upload</label>
                            <div class="custom-file">
                                <input type="file" name="value" class="custom-file-input" id="customFileLang" accept="image/*">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                <br>
                                <img alt="Image" src="{{asset($setting->value)}}" height="50"> 
                                
                            </div>
                        </div>
                    </div>
                    
                    @else
                        @if($setting->type == "gst" ||$setting->type == "app_service"||$setting->type == "force_logout"||$setting->type == "app_version"||$setting->type == "app_update_message"|| $setting->type == "refer_discount")
                            <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" >Value</label>
                                <input type="text" name="value" value="{{$setting->value}}" class="form-control" placeholder="Value" required>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" >Value</label>
                                <textarea type="text" id="editor1" name="value" value="{{$setting->value}}" cols="6" rows="10" class="form-control" placeholder="Value" required>{{$setting->value}}</textarea>
                                </div>
                            </div>
                        @endif
                     @endif
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