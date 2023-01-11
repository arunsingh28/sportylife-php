@extends('admin.layouts.main')
@section('breadcrumb')
Live Video Update
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Live Video Update</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('live-videos')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('live-video-update')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Live Video information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >User Type</label>
                           <select name="user_type" class="form-control" required>
                               <option value="adult" <?php if($data->user_type == 'adult'){echo "selected";} ?>>Adult</option>
                               <option value="kid" <?php if($data->user_type == 'kid'){echo "selected";} ?>>Kid</option>
                               <option value="sporty_kid" <?php if($data->user_type == 'sporty_kid'){echo "selected";} ?>>Sporty Kid</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Category</label>
                           <select name="category_id" id="" class="form-control" required> 
                                @foreach($workoutcate as $item)
                                <option value="{{$item->id}}" <?php if($item->id == $data->category_id){echo "selected";}?>>{{$item->title}}</option>
                                @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="hidden" name="id" class="form-control" value="{{$data->id}}" placeholder="Enter Title" >
                           <input type="hidden" name="length" class="form-control" value="{{$data->length}}" placeholder="Enter Title" >
                           <input type="text" name="title" class="form-control" value="{{$data->title}}" placeholder="Enter Title" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <select name="status" class="form-control" required>
                               <option value="1" <?php if($data->status == '1'){echo "selected";} ?>>Active</option>
                               <option value="0" <?php if($data->status == '0'){echo "selected";} ?>>Inactive</option>
                           </select>
                        </div>
                     </div>
                     
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Start Date </label>
                           <input type="datetime-local"  name="start_date_time" class="form-control" value="{{date('Y-m-d\TH:i', strtotime($data->start_date_time))}}" placeholder="Enter Start Date" required>
                        </div>
                     </div>
                     
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Video</label>
                           <div class="custom-file">
                                <input type="file" name="video" class="custom-file-input" id="customFileLang" accept="video/*">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                <br>
                                <video width="200"  controls>
                                    <source src="{{asset($data->video)}}" type="video/mp4">
                                    <!-- <source src="movie.ogg" type="video/ogg"> -->
                                </video>
                            </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Is Allow Free Trial </label> &nbsp;
                           <input type="checkbox" name="is_allow_free_trial" <?php if($data->is_allow_free_trial == '1'){echo "checked";} ?>>
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Description </label>
                           <textarea name="description" class="form-control" value="{{$data->description}}" placeholder="Description" id="" cols="5" rows="5">{{$data->description}}</textarea>
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