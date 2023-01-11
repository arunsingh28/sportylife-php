@extends('admin.layouts.main')
@section('breadcrumb')
    User Details
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
                            <h3 class="btn btn-default mb-0">User Details</h3>
                            <a href="{{url('/admin/user-packages',$user->id)}}"><h3 class="btn btn-outline-default mb-0">User Package Details</h3></a>
                            <a href="{{url('/admin/user-family-members',$user->id)}}"><h3 class="btn btn-outline-default mb-0">Members Details</h3></a>
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
                <!-- <form method="post" action="{{route('user-update')}}" enctype="multipart/form-data">
               @csrf -->
                    <h6 class="heading-small text-muted mb-4">User information</h6>
                    <div class="div-lg-6">
                        <div class="row card_pt">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Name :- {{$user->name}}</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Email :- {{$user->email}}</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Phone :- {{$user->phone}}</label>
                                    <h4></h4>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Date of Birth :-{{$user->dob}} </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Gender :- {{$user->gender}}</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">City :- {{$user->city ? $user->city : 'N/A'}}</label>
                                    <h4></h4>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">State :- {{$user->state ? $user->state : 'N/A'}}</label>
                                    <h4></h4>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Weight :- {{$user->weight ? $user->weight : 'N/A'}}</label>
                                    <h4></h4>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Height (Feet) :- {{$user->height_feet ? $user->height_feet : 'N/A'}}</label>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Height (Inch) :- {{$user->height_inch ? $user->height_inch : 'N/A'}}</label>
                                    <h4></h4>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Status :-
                                        <?php if ($user->status == '1') {
                                            echo "Active";
                                        } ?>
                                        <?php if ($user->status == '0') {
                                            echo "Inactive";
                                        } ?>
                                    </label>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Image</label>

                                    @if($user->image != NULL)
                                        <a href="{{ asset($user->image ?? '') }}" class="ply-btn" data-id="{{ $user->id ?? '' }}">
                                        <img alt="Image placeholder" src="{{asset($user->image)}}" height="50">
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Refer By </label>
                                    {!! $referbyuser !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Language :- {{$user->languagedata->language_title ?? 'N/A'}}</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Unique No :- {{$user->school_unique_id ?? 'N/A'}}</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">PinCode :- {{$user->zipcode ?? 'N/A'}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <hr class="my-4" />
                    <button type="submit" class="btn btn-sm btn-default">Save</button>
                 </form> -->
                </div>
            </div>
            {{--<div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">User Orders</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="myTable">
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
                            <tbody class="list">
                            <?php $i = 1;?>
                            --}}{{--{{$user->orders[0]}}{{die()}}--}}{{--
                            @if($user->orders)
                                @foreach($user->orders as $key => $item )
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$item->order_id ?? ''}}</td>
                                        <td>{{$item->razorpay_id ?? ''}}</td>
                                        <td>{{$item->final_amount ?? 0}}</td>
                                        <td>{{$item->payment_status ?? ''}}</td>
                                        <td>
                                        @if($item->order_items)
                                            @foreach($item->order_items as $order)
                                            <table width="100%" border="2px" class="mt-1">
                                                --}}{{--<thead>
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Value</th>
                                                    </tr>
                                                </thead>--}}{{--
                                                <tbody>
                                                    <tr>
                                                        <th>Package :- </th>
                                                        <td>{{$order->package->title ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Category :- </th>
                                                        <td>{{$order->category->title ?? ''}}</td>
                                                    </tr>
                                                    --}}{{--<tr>
                                                        <th>Category Year Srno :- </th>
                                                        <td>{{$item->category_year_srno ?? ''}}</td>
                                                    </tr>--}}{{--
                                                    <tr>
                                                        <th>Start Date :- </th>
                                                        <td>{{$order->start_date ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>End Date :- </th>
                                                        <td>{{$order->end_date ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status :- </th>
                                                        <td>{!! ($order->status == 1) ? '<font color="green">Active</font>' : '<font color="red">Inactive</font>' !!}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @endforeach
                                        @endif
                                        </td>
                                    </tr>
                                    @php
                                $i++;
                                @endphp
                                @endforeach
                            @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
@endsection
