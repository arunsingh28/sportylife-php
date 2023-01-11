@extends('admin.layouts.main')
@section('breadcrumb')
Contact Us
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Reply to Enquiry</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('contact-us')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('contact-us-update')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">Enquiry information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >User</label>
                           <input type="hidden" name="id" class="form-control" value="{{$reply->id}}">
                           <h4>{{$reply->userdata->name ?? 'User'}}</h4>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <h4>{{ucfirst($reply->status)}}</h4>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Subject</label>
                           <textarea type="text"  name="question" cols="5" rows="5" class="form-control" placeholder="Enter Question" value="{{$reply->subject}}" readonly>{{$reply->subject}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" >Description</label>
                            <textarea type="text"  name="description" cols="5" rows="5" class="form-control" placeholder="Enter Answer" value="{{$reply->description}}" readonly>{{$reply->description}}</textarea>
                        </div>
                     </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" >Reply</label>
                            <textarea type="text" name="admin_reply" cols="5" rows="5" class="form-control" placeholder="Enter Reply"  required></textarea>
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