@extends('admin.layouts.main')
@section('breadcrumb')
Sports Curriculum Add
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Sports Curriculum Add</h3>
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
            <form method="post" action="{{route('sports-curriculum-add')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Sports Curriculum information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Type</label>
                           <select name="type" id="type" class="form-control" required> 
                                <option value="sports">Sports</option>
                                <option value="sporty_kid">Sporty Kid</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6" id="sports_div">
                        <div class="form-group">
                           <label class="form-control-label" >Category</label>
                           <select name="sport_category" id="sport_category" class="form-control" required> 
                                <option value="">Select Option</option>
                                @foreach($sportcategory as $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6" id="sportykid_div" style="display:none;">
                        <div class="form-group">
                           <label class="form-control-label" >Category</label>
                           <select name="sporty_category" id="sporty_category" class="form-control" > 
                              <option value="">Select Option</option>
                                <option value="sporty_kid_7">Sports Kid (4 to 7)</option>
                                <option value="sporty_kid_9">Sports Kid (7 to 9)</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="text" name="title" class="form-control" placeholder="Enter Title" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Video</label>
                           <div class="custom-file">
                                <input type="file" name="video" class="custom-file-input" id="customFileLang" accept="video/*">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                            </div>
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
<script>
   $(function(){
        $("#type").change(function () { 
            var type = $("#type").val();
            if (type == "sports") {
                $("#sports_div").show();
                $("#sportykid_div").hide();
                $("#sport_category").attr("required","required");
                $("#sporty_category").removeAttr("required");
            }else{
                $("#sportykid_div").show();
                $("#sports_div").hide();
                $("#sport_category").removeAttr("required");
                $("#sporty_category").attr("required","required");
            }
        }); 
    });
</script>
@endsection