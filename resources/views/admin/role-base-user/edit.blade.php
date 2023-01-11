@extends('admin.layouts.main')
@section('breadcrumb')
    Sub Admins 
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Sub Admin Update</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('role-base-user')}}" class="btn btn-sm btn-default">List</a>
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
                    <form method="post" action="{{route('role-base-user-update')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <h6 class="heading-small text-muted mb-4">Sub Admin information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Roles</label>
                                        <select name="role_id" class="form-control" id="" required>
                                            @foreach($roles as $key => $item)
                                                <option value="{{$item->id}}" @if($data->role_id == $item->id) selected @endif>{{$item->role_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="">Select Option</option>
                                            <option value="1" @if($data->status == '1') selected @endif >Active</option>
                                            <option value="0" @if($data->status == '0') selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control" value="{{$data->first_name}}" placeholder="First Name"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" value="{{$data->last_name}}" placeholder="Last Name"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{$data->email}}" placeholder="Email"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Mobile</label>
                                        <input type="text" name="phone" class="form-control" value="{{$data->phone}}" placeholder="Mobile"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label"> Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password ">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <hr class="my-4"/>
                        <button type="submit" class="btn btn-sm btn-default">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
