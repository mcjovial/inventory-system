@extends('layouts.backend.app')

@section('title', 'Order')

@push('css')
    <style>
        .modal-lg {
            max-width: 50% !important;
        }
    </style>
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Debt Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Debt Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        {{ $debtor->full_name }}
                                        <!-- <small class="float-right">Date: {{ date('l, d-M-Y h:i:s A') }}</small> -->
                                        {{-- <smalll class="float-right">Date: {{ \Carbon\Carbon::parse($order->created_at)->toFormattedDateString() }}</smalll> --}}
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    {{-- <address>
                                        <strong>Admin, {{ config('app.name') }}</strong><br>
                                        {{ $company->address }}<br>
                                        {{ $company->city }} - {{ $company->zip_code }}, {{ $company->country }}<br>
                                        Phone: (+234) {{ $company->mobile }} {{ $company->phone !== null ? ', +234'.$company->phone : ''  }}<br>
                                        Email: {{ $company->email }}
                                    </address> --}}
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                        <tr>
                                            <th>S.N</th>
                                            {{-- <th>Product Name</th> --}}
                                            {{-- <th>Product Code</th> --}}
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          {{-- {{dd($total)}} --}}
                                            @foreach($debts as $debt)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    {{-- <td>{{ $order_detail->product->name }}</td> --}}
                                                    {{-- <td>{{ $order_detail->product->code }}</td> --}}
                                                    <td>{{ $debt->amount }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($debt->created_at)->toFormattedDateString() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-4">
                                    {{-- <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width:50%">Payment Method:</th>
                                                <td class="text-right"><b>{{ $order->payment_status }}</b></td>
                                            </tr>
                                            <tr>
                                                <th>Pay</th>
                                                <td class="text-right"><span>&#8358;</span>{{ number_format($order->pay, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Debt</th>
                                                <td class="text-right"><span>&#8358;</span>{{ number_format($order->debt, 2) }}</td>
                                            </tr>
                                        </table>
                                    </div> --}}
                                </div>
                                <!-- /.col -->
                                <div class="col-4 offset-4">
                                    <div class="table-responsive">
                                        <table class="table">
                                            {{-- <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td class="text-right"><span>&#8358;</span>{{ number_format($order->sub_total, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (21%)</th>
                                                <td class="text-right"><span>&#8358;</span>0</td>
                                            </tr> --}}
                                            <tr>
                                                <th>Total:</th>
                                                <td class="text-right"><span>&#8358;</span>{{ round($total) }} Naira</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->





@endsection



@push('js')

@endpush
