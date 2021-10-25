@extends('layouts.backend.app')

@section('title', 'Dashboard')

@push('css')


@endpush

@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1>Dashboard</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div>
				</div>
			</div><!-- /.container-fluid -->
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Today's Sale</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $today->sum('total') }}</span>

                                @php

                                    if ($yesterday->sum('total') != 0)
                                    {
                                        $percentage = (($today->sum('total') - $yesterday->sum('total'))/ $yesterday->sum('total'))*100;
                                    } else {
                                        $percentage = 0;
                                    }

                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage < 0 ? 'text-warning' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('l', strtotime('-1 day')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">This Month's Sale</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $month->sum('total') }}</span>
                                @php

                                    if ($previous_month->sum('total') != 0)
                                    {
                                        $percentage = (($month->sum('total') - $previous_month->sum('total'))/ $previous_month->sum('total'))*100;
                                    } else {
                                        $percentage = 0;
                                    }

                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>
                                <span class="progress-description {{ $percentage < 0 ? 'text-warning' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('F', strtotime('-1 month')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">This Year's Sale</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $year->sum('total') }}</span>
                                @php

                                    if($previous_year->sum('total') != 0)
                                    {
                                        $percentage = (($year->sum('total') - $previous_year->sum('total'))/ $previous_year->sum('total'))*100;
                                    } else {
                                        $percentage = 0;
                                    }
                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>
                                <span class="progress-description {{ $percentage < 0 ? 'text-warning' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('Y', strtotime('-1 year')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text mt-3 pb-1">Total Sale</span>
                                <span class="info-box-number mb-3"><span>&#8358;</span>{{ $sales->sum('total') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fa fa-money"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Today's Paid</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $today->sum('pay') }}</span>
                                @php

                                    if($yesterday->sum('pay') != 0)
                                    {
                                        $percentage = (($today->sum('pay') - $yesterday->sum('pay'))/ $yesterday->sum('pay'))*100;
                                    } else {
                                        $percentage = 0;
                                    }

                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage < 0 ? 'text-warning' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('l', strtotime('-1 day')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fa fa-money"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">This Month's Paid</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $month->sum('pay') }}</span>
                                @php
                                    if($previous_month->sum('pay') != 0)
                                    {
                                        $percentage = (($month->sum('pay') - $previous_month->sum('pay'))/ $previous_month->sum('pay'))*100;
                                    } else {
                                        $percentage = 0;
                                    }

                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage < 0 ? 'text-warning' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('F', strtotime('-1 month')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fa fa-money"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">This Year's Paid</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $year->sum('pay') }}</span>
                                @php

                                    if($previous_month->sum('pay') != 0)
                                    {
                                        $percentage = (($year->sum('pay') - $previous_year->sum('pay'))/ $previous_year->sum('pay'))*100;
                                    } else {
                                        $percentage = 0;
                                    }


                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage < 0 ? 'text-warning' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('Y', strtotime('-1 year')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fa fa-money"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text mt-3 pb-1">Total Paid</span>
                                <span class="info-box-number mb-3"><span>&#8358;</span>{{ $sales->sum('pay') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fa fa-bell-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Today's Debt</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $today->sum('debt') }}</span>
                                @php

                                    if($yesterday->sum('debt') != 0)
                                    {
                                        $percentage = (($today->sum('debt') - $yesterday->sum('debt'))/ $yesterday->sum('debt'))*100;
                                    } else {
                                        $percentage = 0;
                                    }

                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage < 0 ? 'text-success' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('l', strtotime('-1 day')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fa fa-bell-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">This Month's Debt</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $month->sum('debt') }}</span>
                                @php

                                    if($previous_month->sum('debt') != 0)
                                    {
                                        $percentage = (($month->sum('debt') - $previous_month->sum('debt'))/ $previous_month->sum('debt'))*100;
                                    } else {
                                        $percentage = 0;
                                    }


                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage < 0 ? 'text-success' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('F', strtotime('-1 month')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fa fa-bell-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">This Year's Debt</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $year->sum('debt') }}</span>
                                @php
                                    if($previous_year->sum('debt') != 0)
                                    {
                                        $percentage = (($year->sum('debt') - $previous_year->sum('debt'))/ $previous_year->sum('debt'))*100;
                                    } else {
                                        $percentage = 0;
                                    }
                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage < 0 ? 'text-success' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('Y', strtotime('-1 year')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fa fa-bell-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text mt-3 pb-1">Total Debt</span>
                                <span class="info-box-number mb-3"><span>&#8358;</span>{{ $sales->sum('debt') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fa fa-minus-square"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Today's Expenses</span>
                                <span class="info-box-number">{{ $today_expenses->sum('amount') }}</span>

                                @php

                                    if($yesterday_expenses->sum('amount') != 0)
                                    {
                                        $percentage = (($today_expenses->sum('amount') - $yesterday_expenses->sum('amount'))/ $yesterday_expenses->sum('amount'))*100;
                                    } else {
                                        $percentage = 0;
                                    }
                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{  number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage < 0 ? 'text-success' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('l', strtotime('-1 day')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fa fa-minus-square"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">This Month's Expenses</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $month_expenses->sum('amount') }}</span>
                                @php
                                    if($yesterday_expenses->sum('amount') != 0)
                                    {
                                        $percentage = (($today_expenses->sum('amount') - $yesterday_expenses->sum('amount'))/ $yesterday_expenses->sum('amount'))*100;
                                    } else {
                                        $percentage = 0;
                                    }


                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage < 0 ? 'text-success' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('F', strtotime('-1 month')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fa fa-minus-square"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">This Year's Expenses</span>
                                <span class="info-box-number"><span>&#8358;</span>{{ $year_expenses->sum('amount') }}</span>
                                @php
                                    if($previous_year_expenses->sum('amount') != 0)
                                    {
                                        $percentage = (($year_expenses->sum('amount') - $previous_year_expenses->sum('amount'))/ $previous_year_expenses->sum('amount'))*100;
                                    } else {
                                        $percentage = 0;
                                    }
                                @endphp

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ number_format(abs($percentage), 2) }}%"></div>
                                </div>

                                <span class="progress-description {{ $percentage > 0 ? 'text-warning' : '' }}">
                                  {{ number_format(abs($percentage), 2) }} % {{ $percentage > 0 ? 'Increase' : 'Decrease' }} From {{ date('Y', strtotime('-1 year')) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fa fa-minus-square"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text mt-3 pb-1">Total Expenses</span>
                                <span class="info-box-number mb-3"><span>&#8358;</span>{{ $expenses->sum('amount') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
				<div class="row">
					<div class="col-md-6">
						<!-- AREA CHART -->
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Sales Report</h3>
							</div>
							<div class="card-body">
								<div class="chart">
									<div id="barchart_material" style="width: 900px; height: 500px;"></div>
								</div>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
					<div class="col-md-6">
						<!-- AREA CHART -->
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Expenses Report</h3>
							</div>
							<div class="card-body">
								<div class="chart">
									<div id="barchart_material2" style="width: 900px; height: 500px;"></div>
								</div>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
				</div>
				<!-- /.row -->
			</div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

@endsection

@push('js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Month', 'Sales {{ date('Y') }}'],
                @foreach($current_sales as $sale)
                    ["{{ date('M', mktime('0', 0, 0, $sale['months'], 10)) }}", {{ $sale['sums'] }}],
                @endforeach
			]);

            var options = {
                title: 'Monthly Sales Report',
                width: 700,
                legend: { position: 'none' },
                chart: { title: 'Monthly Sales Report {{ date('Y') }}',
                    subtitle: 'Monthly Sales Report' },
                bars: 'vertical', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: { side: 'bottom', label: 'Month'} // Top x-axis.
                    }
                },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.charts.Bar(document.getElementById('barchart_material'));
            chart.draw(data, options);
		}
	</script>

	<script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Month', 'Sales {{ date('Y') }}'],
                @foreach($current_expenses as $expense)
                    ["{{ date('M', mktime('0', 0, 0, $expense['months'], 10)) }}", {{ $expense['sums'] }}],
                @endforeach
            ]);

            var options = {
                title: 'Monthly Expenses Report',
                width: 700,
                legend: { position: 'none' },
                chart: { title: 'Monthly Expenses Report {{ date('Y') }}',
                    subtitle: 'Monthly Expenses Report' },
                bars: 'vertical', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: { side: 'bottom', label: 'Month'} // Top x-axis.
                    }
                },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.charts.Bar(document.getElementById('barchart_material2'));
            chart.draw(data, options);
        }


	</script>


@endpush
