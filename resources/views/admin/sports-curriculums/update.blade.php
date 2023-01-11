@extends('admin.layouts.main')
@section('breadcrumb')
Sports Curriculum Update
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Sports Curriculum Update</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('sports-curriculum')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('sports-curriculum-update')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Sports Curriculum information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Type</label>
                           <input type="text" name="type" class="form-control" value="{{$data->type}}" placeholder="Enter Type" readonly>
                           <input type="hidden" name="id" value="{{$data->id}}">
                           <!-- <select name="type" id="type" class="form-control"> 
                                <option value="sports" <?php if($data->type == 'sports'){echo "selected";} ?>>Sports</option>
                                <option value="sporty_kid" <?php if($data->type == 'sporty_kid'){echo "selected";} ?>>Sporty Kid</option>
                           </select> --> 
                        </div>
                     </div>
                     @if($data->type =="sports")
                     <div class="col-lg-6" id="sports_div">
                        <div class="form-group">
                           <label class="form-control-label" >Category</label>
                           
                           <select name="sport_category" id="sport_category" class="form-control" required> 
                                @foreach($sportcategory as $item)
                                <option value="{{$item->id}}" <?php if($item->id == $data->category){echo "selected";}?>>{{$item->title}}</option>
                                @endforeach
                           </select>
                        </div>
                     </div>
                     @else
                     
                     <div class="col-lg-6" id="sportykid_div">
                        <div class="form-group">
                           <label class="form-control-label" >Category</label>
                           <select name="sporty_category" id="sporty_category" class="form-control">
                              <option value="sporty_kid_7" <?php if($data->category == 'sporty_kid_7'){echo "selected";} ?>>Sports Kid (4 to 7)</option>
                                <option value="sporty_kid_9" <?php if($data->category == 'sporty_kid_9'){echo "selected";} ?>>Sports Kid (7 to 9)</option>
                           </select>
                        </div>
                     </div>
                     @endif
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="text" name="title" class="form-control" value="{{$data->title}}" placeholder="Enter Title" >
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
                           <label class="form-control-label" >Status</label>
                           <select name="status" class="form-control" required>
                               <option value="1" <?php if($data->status == '1'){echo "selected";} ?>>Active</option>
                               <option value="0" <?php if($data->status == '0'){echo "selected";} ?>>Inactive</option>
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
@section('script')

@endsection