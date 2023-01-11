@extends('admin.layouts.main')
@section('breadcrumb')
Slider Details
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Slider Details</h3>
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
                           <h4>{{$slider->title}}</h4>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Image</label>

                           <br>
                            <a href="{{ asset($slider->image) }}" class="ply-btn" data-id="{{ $slider->id }}"><img alt="Image placeholder" src="{{asset($slider->image)}}" height="50"></a>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Slider's Sr. No</label>
                           <h4>{{$slider->position}} </h4>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <h4>
                               <?php if($slider->status == '1'){echo "Active";} ?>
                               <?php if($slider->status == '0'){echo "Inactive";} ?>
                            </h4>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Redirect To</label>
                           <h4>
                               <?php if($slider->redirect_to == 'frc'){echo "FRC";} ?>
                               <?php if($slider->redirect_to == 'nutrition'){echo "Nutrition";} ?>
                               <?php if($slider->redirect_to == 'services'){echo "Services";} ?>
                               <?php if($slider->redirect_to == 'live_session'){echo "Live session";} ?>
                               <?php if($slider->redirect_to == 'workout_videos'){echo "Workout videos";} ?>
                               <?php if($slider->redirect_to == 'no_redirection'){echo "No Redirection";} ?>
                            </h4>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Description</label>
                           <h4>{{$slider->description}} </h4>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- <hr class="my-4" />
               <button type="submit" class="btn btn-sm btn-default">Save</button> -->
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
