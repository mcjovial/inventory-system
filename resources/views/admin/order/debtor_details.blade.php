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
                                </div>
                                <!-- /.col -->
                              </div>
                              <!-- info row -->
                              <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                  <h4>
                                      {{ $debtor->full_name }}
                                  </h4>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                  @if ($total > $max_debt)
                                    <span class="btn btn-lg btn-outline-danger btn-danger float-right">Debt limit of <span>&#8358;</span>{{ $max_debt }} exceeded</span>
                                  @endif
                                </div>
                                  <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <br>
                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($debts as $debt)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $debt->amount }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($debt->order->created_at)->toFormattedDateString() }}</td>
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
                                </div>
                                <!-- /.col -->
                                <div class="col-4 offset-4">
                                    <div class="table-responsive">
                                        <table class="table">
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
