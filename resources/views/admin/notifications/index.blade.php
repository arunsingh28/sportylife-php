@inject('Roles', 'App\Models\Roles')
<?php @$roles_data = $Roles->where('id', auth()->user()->role_id)->first();?>
@extends('admin.layouts.main')
@section('breadcrumb')
    Notifications
@endsection
@section('style')
    <style>
        .pagination {
            float: right;
            padding: 20px;
        }
        .fiterDiv {
            border: 0.5px solid #172b4d;
            padding: 5px;
            margin-top: 30px;
            border-radius: 10px;
            margin-bottom: 15px;
            /* box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px; */
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Notifications List </h3>
                        </div>
                        <div class="col-4 text-right">
                            @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3" || auth()->user()->role_id == "10" || $roles_data->type == "new")
                            <a href="{{route('notifications-add')}}"
                               class="btn btn-sm btn-default float-right">Add</a>
                               @endif 
                        </div>
                    </div>
                    <form method="get" action="{{route('notifications')}}" enctype="multipart/form-data">
                        <div class="fiterDiv">
                            <h3 class="ml-3 mt-1">Filter 
                                <a href="{{route('notifications')}}" class="btn btn-sm btn-primary float-right mr-3">Reset</a>
                                <button class="btn btn-sm btn-default float-right mr-3 " type="submit"> Search </button> 
                                </h3>
                                <hr class="mt-0 mb-0 ml-3 mr-3">
                                <div class="row ">
                                    <div class="col-lg-4 ml-3" >
                                        <div class="form-group">
                                            <label class="form-control-label">From Date</label>
                                            <input type="date" name="from_date" value="<?php if(@$_GET['from_date']){ echo date('Y-m-d',strtotime($_GET['from_date']));} ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 ml-3" >
                                        <div class="form-group">
                                            <label class="form-control-label">To Date</label>
                                            <input type="date" name="to_date" value="<?php if(@$_GET['to_date']){ echo date('Y-m-d',strtotime($_GET['to_date']));} ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th>Sr. </br>No</th>
                            <th>Type</th>
                            <th>User</th>
                            <th>Title</th>
                            <!-- <th>Image</th> -->
                            <th>Data</th>
                            <th>Created Date</th>
                            {{-- <th>Status</th> --}}
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        <?php $i = 1;?>
                        @foreach($data as $key => $item )
                            <tr>
                                <th>
                                    {{$i}}
                                </th>
                                <th>
                                    {{ucfirst($item->type)}}
                                </th>
                                <td>
                                    {{$item->user->name ?? '-'}}
                                </td>
                                <td>
                                    {{$item->title}}
                                </td>
                                <!-- <td>
                                    @if($item->image)
                                        <a href="{{ asset($item->image) }}" class="ply-btn" data-id="{{ $item->id }}"><img src="{{asset($item->image)}}" alt="{{$item->title}}" width="50px"></a>
                                    @endif
                                </td> -->
                                <td>
                                    @if($item->data)
                                        @foreach($item->data as $key=>$exclude)
                                            {{ucfirst($key)}}:- {{$exclude}}<br/>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    {{date('d-m-Y H:i:s',strtotime($item->created_at))}}
                                </td>
                                {{-- <td>
                                    {{($item->status == 1) ? 'read' : 'unread'}}
                                </td> --}}
                                {{--<td>
                                    <label class="switch">
                                        <input type="checkbox" class="changestatus" data-id="{{$item->id}}"
                                               data-on="Active"
                                               data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>--}}
                                <td>
                                    {{--<a href="{{url('/admin/service-packages-edit',$item->id)}}"
                                       class="btn btn-sm btn-primary">Edit</a>--}}
                                       @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "10" || $roles_data->type == "new")
                                    <a href="{{url('/admin/notifications-delete',$item->id)}}"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
                                       @endif
                                </td>
                            </tr>
                            {{--{{$item}}{{die()}}--}}
                            <?php $i++;?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        /*$(function () {
            $('#myTable').on('change', 'tbody input.changestatus', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("/admin/change-notifications-status")}}',
                    data: {'status': status, 'id': id},
                    success: function (data) {
                        console.log(data.success)
                    }
                });
            })
        })*/
    </script>
@endsection
