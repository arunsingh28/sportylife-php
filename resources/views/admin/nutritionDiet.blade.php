@extends('admin.layouts.main')
@section('breadcrumb')
    User Diet Chart
@endsection
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">User Diet Chart List </h3>
                    </div>
                    <div class="col-4 text-right">
                        @if(auth()->user()->role_id == "1"  || auth()->user()->role_id == "10" || auth()->user()->role_id == "3") 
                        <a href="{{route('nutrition-diet-add')}}" class="btn btn-sm btn-default float-right">Add</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Sr. No</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        <?php $i = 1; ?>
                        @foreach($data as $key => $item )
                        <tr>
                            <th>
                                {{$i}}
                            </th>
                            <td>
                                {{$item->userdata->name ?? 'N/A'}}
                            </td>
                            <td>
                                {{$item->userdata->email ?? 'N/A'}}
                            </td>
                            <td>
                                @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3"|| auth()->user()->role_id == "4" || auth()->user()->role_id == "10") 
                                <a href="{{url('/admin/nutrition-diet-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                @endif
                                @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3"|| auth()->user()->role_id == "10") 
                                <a href="{{url('/admin/nutrition-diet-delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
                                <a href="{{url('/admin/nutrition-diet-share',$item->id)}}" class="btn btn-sm btn-default">Share By Email</a>
                                @endif
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
