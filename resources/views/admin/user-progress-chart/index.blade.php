@extends('admin.layouts.main')
@section('breadcrumb')
    User Progress
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
                            <a href="{{url('/admin/user-family-members',$user->id)}}"><h3 class="btn btn-outline-default mb-0">Members Details</h3></a>
                            <h3 class="btn btn-default mb-0">Progress Chart</h3>
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
                    <!-- <h6 class="heading-small text-muted mb-4">User Progress Chart</h6> -->
                        <div class="row ">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header bg-transparent">
                                        <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                                            <h5 class="h3 mb-0">User Progress Chart (Monthly KCAL)</h5>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Chart -->
                                        <div class="chart" style="height: 100% !important;">
                                        <canvas id="monthchart" class="chart-canvas"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- <hr class="my-4" />
                    <button type="submit" class="btn btn-sm btn-default">Save</button>
                 </form> -->
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
    var monthlabel = [<?php foreach ($montharr as $key => $value) {echo "'" . date('M', mktime(0, 0, 0, $key, 10)) . "',";}?>];
    var monthValues = [<?php foreach ($montharr as $value) {echo $value . ",";}?>];
    new Chart("monthchart", {
        type: "bar",
        data: {
        labels: monthlabel,
        datasets: [
            {
                data: monthValues,
                backgroundColor: "#fb6340",
                fill: true,
            }
        ]
        },
        options: {
                
            scales: {
            xAxes: [
                {
                    barThickness : 15,
                }
            ]
        },
            responsive: true,

        legend: {display: false},
        tooltips: {
                // titleFontSize:30 ,
                bodyFontSize:17
            }
        }
    });
</script>
@endsection
