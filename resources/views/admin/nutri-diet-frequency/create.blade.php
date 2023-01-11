@extends('admin.layouts.main')
@section('breadcrumb')
    Nutrition Recipe Categories Add
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Nutrition Recipe Categories Add</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('nutri-diet-frequency')}}" class="btn btn-sm btn-default">List</a>
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
                    <form method="post" action="{{route('nutri-diet-frequency-add')}}" enctype="multipart/form-data">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Nutrition Recipe Categories information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="hidden" name="id"  class="form-control" value="">
                                        <label class="form-control-label">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="">Select Option</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
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
