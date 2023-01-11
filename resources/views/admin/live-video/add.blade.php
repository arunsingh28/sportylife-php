@extends('admin.layouts.main')
@section('breadcrumb')
Live Video Add
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Live Video Add</h3>
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
            <form method="post" action="{{route('live-video-add')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Live Video information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >User Type</label>
                           <select name="user_type" class="form-control" required>
                               <option value="">Select Option</option>
                               <option value="adult">Adult</option>
                               <option value="kid">Kid</option>
                               <option value="sporty_kid">Sporty Kid</option>
                           </select>
                        </div>
                     </div>
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
                           <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
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
                           <label class="form-control-label" >Start Date </label>
                           <input type="datetime-local" name="start_date_time" class="form-control" placeholder="Enter Start Date" required>
                        </div>
                     </div>
                     
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Video</label>
                           <div class="custom-file">
                                <input type="file" name="video" class="custom-file-input" id="customFileLang" accept="video/*" required>
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                            </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Is Allow Free Trial </label> &nbsp;
                           <input type="checkbox" name="is_allow_free_trial" value="1">
                        </div>
                     </div>

                     
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Description </label>
                           <textarea name="description" class="form-control" placeholder="Description" id="" cols="5" rows="5"></textarea>
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