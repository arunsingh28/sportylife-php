@extends('admin.layouts.main')
@section('breadcrumb')
    User Members Details
@endsection
@section('content')
    <style>
        .heading-small h4 {
            font-weight: bolder;
        }
        /*.col-lg-6 {
            border-bottom: #fff dotted 1px !important;
        }*/
        .card_pt {
            background: #e94637;
            padding: 15px;
            border-radius: 15px;
        }
        .card_pt label.form-control-label {
            color: #fff;
        }
        .card_pt .col-lg-6 {
            border: 1px solid #fff;
        }
    </style>
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <a href="{{url('/admin/user-view',$user->id)}}"><h3 class="btn btn-outline-default mb-0">User Details</h3></a>
                            <a href="{{url('/admin/user-packages',$user->id)}}"><h3 class="btn btn-outline-default mb-0">User Package Details</h3></a>
                            <h3 class="btn btn-default mb-0 mr-0">Members Details</h3>
                            <a href="{{url('/admin/user-progress-chart',$user->id)}}"><h3 class="btn btn-outline-default mb-0">Progress Chart</h3></a>
                            
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
                    <div class="table-responsive">
                            <?php $i = 1;?>
                            <table class="table align-items-center table-flush" id="myTable">
                                <thead>
                                <tr>
                                    <th>Sr. No. </th>
                                    <th>Name </th>
                                    <th>Email </th>
                                    <th>Mobile</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($family_user[0]))
                                    @foreach($family_user as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{@$item->first_name.' '.@$item->last_name}}</td>
                                        <td>{{$item->email ?? ''}}</td>
                                        <td>{{$item->phone ?? ''}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            
                    </div>
                        
                    
                </div>
            </div>
            
        </div>
    </div>
@endsection
