@extends('admin.layouts.main')
@section('breadcrumb')
    Dashboard
@endsection
@section('dashboarddata')
    <style>
        .image-box {
            margin: auto;
            width: 98%;
            height: 98%;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease-in-out;
        }

        /* Create the hidden pseudo-element */
        /* include the shadow for the end state */
        .image-box:hover {
            z-index: -1;
            width: 100%;
            height: 100%;
            opacity: 99;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.30);
            transition: opacity 0.3s ease-in-out;
        }
        
    </style>
    @if(auth()->user()->role_id == '1' && auth()->user()->is_verify == '0')

    
      <div class="row">
         <div class="col-xl-12 order-xl-1">
            <div class="card">
               <div class="card-body">
                  @if($errors->any())
                     {!! implode('', $errors->all('
                        <div class="alert alert-warning" role="alert">
                              :message
                        </div>
                     ')) !!}
                  @endif
                  <form method="post" action="{{route('admin.verify-otp')}}" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="id" value="{{auth()->user()->id}}">
                     <h6 class="heading-small text-muted mb-4">Verify OTP</h6>
                     <h1 class="text-center">Welcome to Sporty Life!!!</h1>
                     <h4 class="text-center">{{$message}}</h4>
                     <div class="row justify-content-center">
                        <div class="col-md-6">
                           <div class="form-group mb-3">
                              <div class="input-group input-group-merge ">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text"><i class="ni ni-key-25"></i></span>
                                    </div>
                                    <input type="text" oninput='digitValidate(this)' maxlength="6"
                                       class="form-control" name="otp" placeholder="Enter OTP" required>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="text-center">
                        <button type="submit" class="btn btn-default my-4">Verify</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
    @else
    
    
    <div class="row">
        <div class="col-xl-3 col-md-6">
            @if (auth()->user()->role_id == '1')
                <a href="{{ route('users') }}">
                @else
                    <a>
            @endif
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Users</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $total_user_count }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-single-02"></i>
                            </div>
                        </div>
                    </div>
                    <!-- <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
                    </p> -->
                </div>
            </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Orders</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $total_order_count }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Earnings</h5>
                            <span class="h2 font-weight-bold mb-0">&#x20B9; {{ number_format($total_earn, 2) ?? '0' }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-money-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            @if (auth()->user()->role_id == '1')
                <a href="{{ route('service-packages') }}">
                @else
                    <a>
            @endif
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Services</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $package_count }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-books"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        {{-- <div class="col-xl-12 col-md-12" style="height: 52vh !important;"> --}}{{-- <div class="image-box">
         <img src="{{asset('admin/assets/img/banner/banner.png')}}" width="100%" style="border-radius: 20px;shape-image-threshold: initial;">
      </div> --}}{{-- </div> --}}
    </div>
    <div class="row">
        <!-- <div class="col-xl-6">
          <div class="card bg-default">
              <div class="card-header bg-transparent">
                  <div class="row align-items-center">
                      <div class="col">
                          <h6 class="text-light text-uppercase ls-1 mb-1">Overview</h6>
                          <h5 class="h3 text-white mb-0">Revenue According Days</h5>
                      </div>
                      <div class="col">
                          <ul class="nav nav-pills justify-content-end">
                              <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark" data-update='{"data":{"datasets":[{"data":[500, 400, 300, 500, 350, 600, 500, 800]}]}}' data-prefix="$" data-suffix="k">
                                  <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                      <span class="d-none d-md-block">Year</span>
                                      <span class="d-md-none">Y</span>
                                  </a>
                              </li>
                              <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark" data-update='{"data":{"datasets":[{"data":[210, 100, 130, 230, 315, 140, 320, 260]}]}}' data-prefix="$" data-suffix="k">
                                  <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                                      <span class="d-none d-md-block">Month</span>
                                      <span class="d-md-none">M</span>
                                  </a>
                              </li>
                              <li class="nav-item" data-toggle="chart" data-target="#chart-sales-dark" data-update='{"data":{"datasets":[{"data":[40, 20, 5, 25, 10, 30, 15, 40]}]}}' data-prefix="$" data-suffix="k">
                                  <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                                      <span class="d-none d-md-block">Week</span>
                                      <span class="d-md-none">W</span>
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
              <div class="card-body">
                  <div class="chart" >
                      <canvas id="chart-sales-dark" class="chart-canvas"></canvas>
                  </div>
              </div>
          </div>
          </div> -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                            <h5 class="h3 mb-0">Weekly Revenue</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart" style="height: 100% !important;">
                        <canvas id="weekly" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                            <h5 class="h3 mb-0">Monthly Revenue</h5>
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
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                            <h5 class="h3 mb-0">Quarterly Revenue</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart" style="height: 100% !important;">
                        <canvas id="quarterlychart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                            <h5 class="h3 mb-0">6 Months Revenue</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart" style="height: 100% !important;">
                        <canvas id="sixmonthchart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                            <h5 class="h3 mb-0">Yearly Revenue</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart" style="height: 100% !important;">
                        <canvas id="yearly" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>
        //radious
        Chart.elements.Rectangle.prototype.draw = function() {
            var ctx = this._chart.ctx;
            var vm = this._view;
            var left, right, top, bottom, signX, signY, borderSkipped, radius;
            var borderWidth = vm.borderWidth;
            var cornerRadius = 20;

            if (!vm.horizontal) {
                // bar
                left = vm.x - vm.width / 2;
                right = vm.x + vm.width / 2;
                top = vm.y;
                bottom = vm.base;
                signX = 1;
                signY = bottom > top ? 1 : -1;
                borderSkipped = vm.borderSkipped || 'bottom';
            } else {
                // horizontal bar
                left = vm.base;
                right = vm.x;
                top = vm.y - vm.height / 2;
                bottom = vm.y + vm.height / 2;
                signX = right > left ? 1 : -1;
                signY = 1;
                borderSkipped = vm.borderSkipped || 'left';
            }

            // Canvas doesn't allow us to stroke inside the width so we can
            // adjust the sizes to fit if we're setting a stroke on the line
            if (borderWidth) {
                // borderWidth shold be less than bar width and bar height.
                var barSize = Math.min(Math.abs(left - right), Math.abs(top - bottom));
                borderWidth = borderWidth > barSize ? barSize : borderWidth;
                var halfStroke = borderWidth / 2;
                // Adjust borderWidth when bar top position is near vm.base(zero).
                var borderLeft = left + (borderSkipped !== 'left' ? halfStroke * signX : 0);
                var borderRight = right + (borderSkipped !== 'right' ? -halfStroke * signX : 0);
                var borderTop = top + (borderSkipped !== 'top' ? halfStroke * signY : 0);
                var borderBottom = bottom + (borderSkipped !== 'bottom' ? -halfStroke * signY : 0);
                // not become a vertical line?
                if (borderLeft !== borderRight) {
                    top = borderTop;
                    bottom = borderBottom;
                }
                // not become a horizontal line?
                if (borderTop !== borderBottom) {
                    left = borderLeft;
                    right = borderRight;
                }
            }

            ctx.beginPath();
            ctx.fillStyle = vm.backgroundColor;
            ctx.strokeStyle = vm.borderColor;
            ctx.lineWidth = borderWidth;

            // Corner points, from bottom-left to bottom-right clockwise
            // | 1 2 |
            // | 0 3 |
            var corners = [
                [left, bottom],
                [left, top],
                [right, top],
                [right, bottom]
            ];

            // Find first (starting) corner with fallback to 'bottom'
            var borders = ['bottom', 'left', 'top', 'right'];
            var startCorner = borders.indexOf(borderSkipped, 0);
            if (startCorner === -1) {
                startCorner = 0;
            }

            function cornerAt(index) {
                return corners[(startCorner + index) % 4];
            }

            // Draw rectangle from 'startCorner'
            var corner = cornerAt(0);
            ctx.moveTo(corner[0], corner[1]);

            for (var i = 1; i < 4; i++) {
                corner = cornerAt(i);
                nextCornerId = i + 1;
                if (nextCornerId == 4) {
                    nextCornerId = 0
                }

                nextCorner = cornerAt(nextCornerId);

                width = corners[2][0] - corners[1][0];
                height = corners[0][1] - corners[1][1];
                x = corners[1][0];
                y = corners[1][1];

                var radius = cornerRadius;

                // Fix radius being too large
                if (radius > height / 2) {
                    radius = height / 2;
                }
                if (radius > width / 2) {
                    radius = width / 2;
                }

                ctx.moveTo(x + radius, y);
                ctx.lineTo(x + width - radius, y);
                ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
                ctx.lineTo(x + width, y + height - radius);
                ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
                ctx.lineTo(x + radius, y + height);
                ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
                ctx.lineTo(x, y + radius);
                ctx.quadraticCurveTo(x, y, x + radius, y);

            }

            ctx.fill();
            if (borderWidth) {
                ctx.stroke();
            }
        };
        //radious

        var weeklabel = [<?php foreach ($weekdata as $value) {
            echo "'" . $value['day_name'] . "',";
        } ?>];
        var weekValues = [<?php foreach ($weekdata as $value) {
            echo $value['total_final_amount'] . ',';
        } ?>];
        new Chart("weekly", {
            type: "bar",
            data: {
                labels: weeklabel,
                datasets: [{
                    data: weekValues,
                    backgroundColor: "#fb6340",
                    fill: true,

                }]
            },
            options: {
                barRoundness: 5,
                scales: {
                    xAxes: [{
                        barThickness: 15
                    }]
                },
                responsive: true,

                legend: {
                    display: false
                },
                tooltips: {
                    // titleFontSize:30 ,
                    bodyFontSize: 17
                }
            }
        });

        var monthlabel = [<?php foreach ($montharr as $key => $value) {
            echo "'" . date('M', mktime(0, 0, 0, $key, 10)) . "',";
        } ?>];
        var monthValues = [<?php foreach ($montharr as $value) {
            echo $value . ',';
        } ?>];
        new Chart("monthchart", {
            type: "bar",
            data: {
                labels: monthlabel,
                datasets: [{
                    data: monthValues,
                    backgroundColor: "#fb6340",
                    fill: true,
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        barThickness: 15
                    }]
                },
                responsive: true,

                legend: {
                    display: false
                },
                tooltips: {
                    // titleFontSize:30 ,
                    bodyFontSize: 17
                }
            }
        });

        var quarterlylabel = ["Jan-Mar", "Apr-Jun", "Jul-Sep", "Oct-Dec"];
        var quarterlyValues = [<?php echo $total_first_qur . ',' . $total_second_qur . ',' . $total_third_qur . ',' . $total_forth_qur; ?>];
        new Chart("quarterlychart", {
            type: "bar",
            data: {
                labels: quarterlylabel,
                datasets: [{
                    data: quarterlyValues,
                    backgroundColor: "#fb6340",
                    fill: true,
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        barThickness: 15
                    }]
                },
                responsive: true,

                legend: {
                    display: false
                },
                tooltips: {
                    // titleFontSize:30 ,
                    bodyFontSize: 17
                }
            }
        });

        var sixmonthlabel = ["Last 6 Months"];
        var sixmonthValues = [<?php echo $total_prev; ?>];
        new Chart("sixmonthchart", {
            type: "bar",
            data: {
                labels: sixmonthlabel,
                datasets: [{
                    data: sixmonthValues,
                    backgroundColor: "#fb6340",
                    fill: true,
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        barThickness: 15
                    }]
                },
                responsive: true,

                legend: {
                    display: false
                },
                tooltips: {
                    // titleFontSize:30 ,
                    bodyFontSize: 17
                }
            }
        });

        var yearlabel = [<?php foreach ($yeardata as $value) {
            echo "'" . $value['year'] . "',";
        } ?>];
        var yearValues = [<?php foreach ($yeardata as $value) {
            echo $value['total_final_amount'] . ',';
        } ?>];
        new Chart("yearly", {
            type: "bar",
            data: {
                labels: yearlabel,
                datasets: [{
                    data: yearValues,
                    backgroundColor: "#fb6340",
                    fill: true,
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        barThickness: 15
                    }]
                },
                responsive: true,

                legend: {
                    display: false
                },
                tooltips: {
                    // titleFontSize:30 ,
                    bodyFontSize: 17
                }
            }
        });

    </script>
@endsection
