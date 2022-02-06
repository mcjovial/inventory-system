@extends('layouts.backend.app')

@section('title', 'Invoice')

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
                        <h1>Invoice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Invoice</li>
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
                                        <i class="fa fa-globe"></i> {{ config('app.name') }}
                                        <!-- <small class="float-right">Date: {{ date('l, d-M-Y h:i:s A') }}</small> -->
                                        <smalll class="float-right">Date: {{ \Carbon\Carbon::parse($date)->toFormattedDateString() }}</smalll>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>
                                        <strong>Admin, {{ config('app.name') }}</strong><br>
                                        {{ $company->address }}<br>
                                        {{ $company->city }} - {{ $company->zip_code }}, {{ $company->country }}<br>
                                        Phone: (+234) {{ $company->mobile }} {{ $company->phone !== null ? ', +234'.$company->phone : ''  }}<br>
                                        Email: {{ $company->email }}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    To
                                    <address>
                                        <strong>{{ $customer->full_name }}</strong><br>
                                        Phone: (+234) {{ $customer->phone }}<br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Payment Due: <span>&#8358;</span></b> {{ $contents->sum('total') }}<br>
                                    <b>Order Status:</b> <span class="badge badge-warning">Pending</span><br>
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
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Cost</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($contents as $content)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $content->name }}</td>
                                                    <td>{{ $content->quantity }}</td>
                                                    <td><span>&#8358;</span> {{ number_format($content->price, 2) }}</td>
                                                    <td><span>&#8358;</span> {{ $content->total }}</td>
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
                                <div class="col-8"></div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td class="text-right"><span>&#8358;</span> {{ $contents->sum('total') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (0%)</th>
                                                <td class="text-right"><span>&#8358;</span> 0</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td class="text-right"><span>&#8358;</span> {{ $contents->sum('total') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <form action="" method="post">
                                        @csrf
                                        <input type="hidden" name="customer_name" value="{{ $customer->full_name }}">
                                        <input type="hidden" name="customer_phone" value="{{ $customer->phone }}">
                                        {{-- <a href="{{ route('admin.invoice.print', $customer->id) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> --}}
                                        <button type="button" data-toggle="modal" data-target="#paymentModal" class="btn btn-success float-left"><i class="fa fa-credit-card"></i>
                                            Submit Payment
                                        </button>
                                        <a href="{{ route('admin.exchange.create') }}" type="button" class="btn btn-primary float-right"><i class="fa fa-exchange"></i>
                                            Exchange
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!--payment modal -->
    <form action="{{ route('admin.invoice.final_invoice') }}" method="post">
        @csrf
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Invoice of {{ $customer->full_name }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-info float-right mb-3">Payable Total : <span>&#8358;</span>{{ $contents->sum('total') }}</p>
                            </div>
                        </div>
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="customer_name" value="{{ $customer->full_name }}">
                        <input type="hidden" name="customer_phone" value="{{ $customer->phone }}">
                        <input type="hidden" name="cash" value="{{ $contents->sum('total') }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">Payment Method</label>
                                <select name="payment_status" class="form-control" required >
                                    <option value="" disabled selected>Choose a Payment Method</option>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Pay</label>
                                <input type="number" name="pay" class="form-control">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--/.payment modal -->
@endsection



@push('js')

@endpush
