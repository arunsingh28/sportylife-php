@extends('admin.layouts.main')
@section('breadcrumb')
Slider Update
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Slider Update</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('sliders')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('slider-update')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Slider information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="hidden" name="id" value="{{$slider->id}}" class="form-control" placeholder="Title" required>
                           <input type="text" name="title" value="{{$slider->title}}" class="form-control" placeholder="Title" required>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Image</label>
                           <input type="file" class="form-control" name="image" accept="image/*">
                           <span>Image Size should be 1200px*630px</span>
                           <br>
                           <br>
                            <a href="{{ asset($slider->image) }}" class="ply-btn" data-id="{{ $slider->id }}"><img alt="Image placeholder" src="{{asset($slider->image)}}" height="50"></a>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Slider's Sr. No</label>
                           <select name="position" class="form-control" required>
                               <?php for ($i=1; $i <= 10; $i++) {  ?>
                                <option value="{{$i}}" <?php if($slider->position == $i){echo "selected";} ?>>{{$i}}</option>
                               <?php }?>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <select name="status" class="form-control" required>
                               <option value="1" <?php if($slider->status == '1'){echo "selected";} ?>>Active</option>
                               <option value="0" <?php if($slider->status == '0'){echo "selected";} ?>>Inactive</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Redirect To</label>
                           <select name="redirect_to" class="form-control js-example-basic-single" required>
                               <option value="frc" <?php if($slider->redirect_to == 'frc'){echo "selected";} ?>>FRC</option>
                               <option value="nutrition" <?php if($slider->redirect_to == 'nutrition'){echo "selected";} ?>>Nutrition</option>
                               <option value="services" <?php if($slider->redirect_to == 'services'){echo "selected";} ?>>Services</option>
                               <option value="live_session" <?php if($slider->redirect_to == 'live_session'){echo "selected";} ?>>Live session</option>
                               <option value="workout_videos" <?php if($slider->redirect_to == 'workout_videos'){echo "selected";} ?>>Workout videos</option>
                               <option value="no_redirection" <?php if($slider->redirect_to == 'no_redirection'){echo "selected";} ?>>No Redirection</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Description</label>
                           <textarea required class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Enter Description" value="{{$slider->description}}"> {{$slider->description}}</textarea>
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
