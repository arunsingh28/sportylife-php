@extends('admin.layouts.main')
@section('breadcrumb')
  IOS Service Packages 
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">IOS Service Packages List </h3>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="myTable">
                        <thead class="thead-light">
                        <tr>
                            <th>Sr. <br/>No</th>
                            <th class="d-none">Parent <br/>Package</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th class="d-none">Description</th>
                            <th>Duration</th>
                            <th class="d-none">Package <br/>Tag</th>
                            <th>Addon</th>
                            <th class="d-none">Service <br/>Exclude</th>
                            <th class="d-none">Validity <br/>Extend</th>
                            <th>Status</th>
                            <th>Grayed Out</th>
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
                                <td class="d-none">
                                    {{$item->parent->title ?? '-'}}
                                </td>
                                <td>
                                    {{$item->title ?? ''}}
                                </td>
                                <td>
                                    {{$item->price ?? 0}}
                                </td>
                                <td class="d-none">
                                    @if($item->description)
                                    <ol>
                                        @foreach($item->description as $description)
                                            <li>{{$description ?? ''}}</li>
                                        @endforeach
                                    </ol>
                                    @endif
                                </td>
                                <td>
                                    {{$item->package_duration}} {{ucfirst($item->duration_type)}}
                                </td>
                                <td class="d-none">
                                    {{$item->package_tag}}
                                </td>
                                <td>
                                    @if($item->addon == '1')
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                                <td class="d-none">
                                    @if($item->service_exclude)
                                    <ol>
                                        @foreach($item->service_exclude as $exclude)
                                           <li>{{$exclude}}</li>
                                        @endforeach
                                    </ol>
                                    @endif
                                </td>
                                <td class="d-none">
                                    {{$item->validity_extend}}
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
                                    @if($item->parent_id == NULL)
                                    <input type="checkbox" class="changestatus_grayout" data-id="{{$item->id}}" data-on="Active" data-off="InActive" {{ $item->is_grayed_out ? 'checked' : '' }}>
                                    @endif
                                </td>
                                <td>
                                    <!-- <a href="{{url('/admin/service-packages-ios',$item->id)}}"
                                       class="btn btn-sm btn-success">View</a> -->
                                       @if(auth()->user()->role_id != "3" && auth()->user()->role_id != "4" ) 
                                        <a href="{{url('/admin/service-packages-ios-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                       @endif
                                    
                                </td>
                            </tr>
                            {{--{{$item}}{{die()}}--}}
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
                    url: '{{url("/admin/change-service-packages-status")}}',
                    data: {'status': status, 'id': id},
                    success: function (data) {
                        console.log(data.success)
                    }
                });
            })
        })

        $(function () {
            $('#myTable').on('change', 'tbody input.changestatus_grayout', function () {
                var grayed_out_status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("/admin/change-service-packages-grayout")}}',
                    data: {'grayed_out_status': grayed_out_status, 'id': id},
                    success: function (data) {
                        console.log(data.success)
                    }
                });
            })
        })
    </script>
@endsection
