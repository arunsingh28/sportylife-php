@extends('admin.layouts.main')
@section('breadcrumb')
Slider Add
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Slider Add</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('sliders')}}" class="btn btn-sm btn-default">List</a>
               </div>
            </div>
         </div>
         <div class="card-body">
            <form method="post" action="{{route('slider-add')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Slider information</h6>
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
                           <span>Image Size should be 1200px*630px</span>
                        </div>
                     </div>
                  </div>
                
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Slider's Sr. No</label>
                           <select name="position" class="form-control" required>
                               <option value="">Select Option</option>
                               <?php for ($i=1; $i <= 10; $i++) {  ?>
                                <option value="{{$i}}">{{$i}}</option>
                               <?php }?>
                           </select>
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
                           <label class="form-control-label" >Redirect To </label>
                           <select name="redirect_to" class="form-control js-example-basic-single" required>
                               <option value="">Select Option</option>
                               <option value="frc">FRC</option>
                               <option value="nutrition">Nutrition</option>
                               <option value="services">Services</option>
                               <option value="live_session">Live session</option>
                               <option value="workout_videos">Workout videos</option>
                               <option value="no_redirection">No Redirection</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Description</label>
                           <textarea  class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Enter Description"> </textarea>
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