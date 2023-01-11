@extends('admin.layouts.main')
@section('breadcrumb')
User Packages Detail
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
                        <a href="{{url('/admin/user-view',$user->id)}}">
                            <h3 class="btn btn-outline-default mb-0">User Details</h3>
                        </a>
                        <h3 class="btn btn-default mb-0">User Packages Detail</h3>
                        <a href="{{url('/admin/user-family-members',$user->id)}}">
                            <h3 class="btn btn-outline-default mb-0">Members Details</h3>
                        </a>
                        <a href="{{url('/admin/user-progress-chart',$user->id)}}">
                            <h3 class="btn btn-outline-default mb-0">Progress Chart</h3>
                        </a>
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
                <h6 class="heading-small text-muted mb-4">User Package information</h6>
                @if($user->active_order && $user->active_order->active_package)
                @php
                $package = @$user->active_order->active_package;
                @endphp

                <div class="div-lg-6">
                    <h2> Active Service</h2>
                    <div class="row card_pt">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label">Package :- {{$package->package->title ?? ''}} </label>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label">Category :- {{$package->category->title ?? ''}}</label>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label">Start Date :- {{ $package->start_date ?? ''}}</label>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label">End Date :- {{$package->end_date ?? ''}}</label>

                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-lg-12 text-center">
                    <h2 class="p-2 text-danger">This user don't have any active package</h2>
                </div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3>User Packages List</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{--<table class="table align-items-center table-flush" id="myTable">
                            <thead class="thead-light">
                            <tr>
                                <th>Sr. No</th>
                                <th>Order ID</th>
                                <th>Razorpay ID</th>
                                <th>Final <br/>Amount</th>
                                <th>Payment <br/>Status</th>
                                <th>Order Items</th>
                            </tr>
                            </thead>
                            <tbody class="list">--}}
                    <?php $i = 1; ?>
                    {{--{{$user->orders[0]}}{{die()}}--}}
                    <table class="table align-items-center table-flush" id="myTable">
                        <thead>
                            <tr>
                                <th>Package </th>
                                <th>Category </th>
                                {{--<th>Category Year Srno :- </th>--}}
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Addon</th>
                                <th>Order ID</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @if($user->complete_orders)
                        @foreach($user->complete_orders as $key => $item )
                      
                        {{--<tr>
                                        <td>{{$i}}</td>
                        <td>{{$item->order_id ?? ''}}</td>
                        <td>{{$item->razorpay_id ?? ''}}</td>
                        <td>{{$item->final_amount ?? 0}}</td>
                        <td>{{$item->payment_status ?? ''}}</td>
                        <td>--}}
                            @if($item->order_items)
                            <tbody>
                                @foreach($item->order_items as $order)
                                <tr>
                                    <td>{{@$order->package->title ?? ''}}</td>
                                    <td>
                                        @if(@$order->package->is_sports_show == '1')
                                        {{@$order->category->title ?? ''}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    {{--<td>{{$item->category_year_srno ?? ''}}
                        </td>--}}
                        <td>{{$order->start_date ?? ''}}</td>
                        <td>{{$order->end_date ?? ''}}</td>
                        <td>-</td>
                        <td>{{$order->order_id ?? ''}}</td>
                        <td>{!! (date("Y-m-d h:m:s") < $order->end_date ) ? '<font color="green">Active</font>' : '<font color="red">Inactive</font>' !!}</td>
                        <td><a href="{{url('/admin/delete-user-packages/'.$order->order_primary_id.'/'.$user->id)}}" class="btn btn-sm btn-danger text-white">Remove</a></td>
                        </tr>
                        @endforeach
                        @endif
                        {{--</td>
                                    </tr>--}}
                        @php
                        $i++;
                        @endphp
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                    {{--</tbody>

                        </table>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection