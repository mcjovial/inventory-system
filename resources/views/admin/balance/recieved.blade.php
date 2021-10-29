@extends('layouts.backend.app')

@section('title', 'Create Balance')

@push('css')

@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Balance</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Balance a Customer</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.order.balance', $order->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="customer_name" value="{{ $order->customer_name }}">
                                    <input type="hidden" name="customer_phone" value="{{ $order->customer_phone }}">
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Customer</label>
                                                <input type="text" class="form-control" name="name" value="{{ $order->customer_name }}" placeholder="Enter Name">
                                            </div>
                                            <div class="form-group">
                                                <label>Amount</label>
                                                <input type="number" class="form-control" name="amount" value="{{ abs($order->debt) }}" placeholder="Enter Email">
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="pay_out" value="0">
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input type="text" class="form-control" name="description" placeholder="Enter Item Used To Balance">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-md-right">Balance</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@push('js')

@endpush
