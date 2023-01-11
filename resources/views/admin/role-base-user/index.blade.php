@extends('admin.layouts.main')
@section('breadcrumb')
    Sub Admins
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Sub Admins List </h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('role-base-user-add')}}"
                               class="btn btn-sm btn-default float-right">Add</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="myTable">
                        <thead class="thead-light">
                        <tr>
                            <th>Sr. </br>No</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
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
                                <td>
                                    {{@$item->roledata->role_name ?? ''}}
                                </td>
                                <td>
                                    {{$item->name ?? ''}}
                                </td>
                                <td>
                                    {{$item->email}}
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="changestatus" data-id="{{$item->id}}"
                                               data-on="Active"
                                               data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <a href="{{url('/admin/role-base-user-edit',$item->id)}}"
                                       class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{url('/admin/role-base-user-delete',$item->id)}}"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this?');"> Delete </a>
                                </td>
                            </tr>
                           {{-- {{$item}}{{die()}}--}}
                            <?php $i++;?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('#myTable').on('change', 'tbody input.changestatus', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("/admin/change-role-base-user-status")}}',
                    data: {'status': status, 'id': id},
                    success: function (data) {
                        console.log(data.success)
                    }
                });
            })
        })
    </script>
@endsection
