@extends('admin.layouts.main')
@section('breadcrumb')
User Update
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Update User Details</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('users')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('user-update')}}" enctype="multipart/form-data">
               @csrf
               <h6 class="heading-small text-muted mb-4">User information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Name</label>
                           <input type="hidden" name="id" value="{{$user->id}}" class="form-control" placeholder="Title" required>
                           <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="Name" required>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Email</label>
                           <input type="text" name="email" value="{{$user->email}}" class="form-control" placeholder="Email" readonly>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Phone</label>
                           <input type="text" name="phone" value="{{$user->phone}}" class="form-control" placeholder="Phone" readonly>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Date of Birth</label>
                           <input type="date" name="dob" value="{{$user->dob}}" class="form-control" placeholder="Date of Birth" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Gender</label>
                           <select name="status" class="form-control" required>
                              <option value="male" <?php if($user->gender == 'male'){echo "selected";} ?>>Male</option>
                              <option value="female" <?php if($user->gender == 'female'){echo "selected";} ?>>Female</option>
                              <option value="other" <?php if($user->gender == 'other'){echo "selected";} ?>>Other</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                           <label class="form-control-label" >City</label>
                           <input type="text" name="city" value="{{$user->city}}" class="form-control" placeholder="City" >
                        </div>
                     </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                           <label class="form-control-label" >State</label>
                           <input type="text" name="state" value="{{$user->state}}" class="form-control" placeholder="State" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Weight</label>
                           <input type="text" name="weight" value="{{$user->weight}}" class="form-control" placeholder="Weight" >
                        </div>
                     </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                           <label class="form-control-label" >Height (Feet)</label>
                           <input type="text" name="height_feet" value="{{$user->height_feet}}" class="form-control" placeholder="Height (Feet)" >
                        </div>
                     </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                           <label class="form-control-label" >Height (Inch)</label>
                           <input type="text" name="height_inch" value="{{$user->height_inch}}" class="form-control" placeholder="Height (Inch)" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <select name="status" class="form-control" required>
                              <option value="1" <?php if($user->status == '1'){echo "selected";} ?>>Active</option>
                              <option value="0" <?php if($user->status == '0'){echo "selected";} ?>>Inactive</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Image</label>
                           <div class="custom-file">
                              <input type="file" name="image" class="custom-file-input" id="customFileLang" accept="image/*">
                              <label class="custom-file-label" for="customFileLang">Select file</label>
                           </div>
                           <br>
                           <br>
                           @if($user->image != NULL)
                                <a href="{{ asset($user->image ?? '') }}" class="ply-btn" data-id="{{ $user->id ?? '' }}">
                                <img alt="Image placeholder" src="{{asset($user->image)}}" height="50">
                                </a>
                           @else
                           N/A
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
