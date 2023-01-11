@extends('admin.layouts.main')
@section('breadcrumb')
Home Category Update
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Home Category Update</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('home-category')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('home-category-update')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Home Category information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="hidden" name="id" value="{{$data->id}}" class="form-control" placeholder="Title" required>
                           <input type="text" name="title" value="{{$data->title}}" class="form-control" placeholder="Title" required>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Image</label>
                           <input type="file" id="image" class="form-control" name="image" accept="image/*">
                           <span style="color:red;">Image Size should be lessthan 1MB</span>
                           <br>
                           <br>
                           @if($data->image != NULL)
                           <a href="{{ asset($data->image) }}" class="ply-btn" data-id="{{ $data->id }}"><img alt="Image placeholder" src="{{asset($data->image)}}" height="50"></a>
                           @else
                           <span style="color:red;">Not Image Uploaded!</span>
                           @endif
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
<script type="text/javascript">
  $('#image').on('change', function() {
   //   console.log($(this)[0].files[0].name+' file size is: ' + $(this)[0].files[0].size/1024 + 'kb');
     $imagesize = $(this)[0].files[0].size/1024;
     if ($imagesize >= 1024) {
        $("#image").val('');
        alert("Please upload image lessthan 1MB")
      }else{
         return true;
     }
  });
</script>
@endsection
