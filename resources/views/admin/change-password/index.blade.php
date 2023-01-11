@extends('admin.layouts.main')
@section('breadcrumb')
Change Password
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Change Password</h3>
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
            <form method="post" action="{{route('admin.change-password')}}" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="id" value="1">
               <h6 class="heading-small text-muted mb-4">Password Details</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >E-mail</label>
                           <input type="email" name="email" value="{{$user->email}}"  class="form-control" placeholder="Enter E-mail">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Mobile</label>
                           <input type="text" name="phone"  value="{{$user->phone}}" class="form-control" placeholder="Enter Mobile">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Password</label>
                           <input type="password" name="password"  class="form-control" placeholder="Enter Password" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Confirm Password</label>
                           <input type="text" name="password_confirmation"  class="form-control" placeholder="Re-enter Password" >
                        </div>
                     </div>
                     </div>
               </div>
               <hr class="my-4" />
               <button type="submit" class="btn btn-sm btn-default">Update</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
@section("script")

@endsection
