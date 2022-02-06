@extends('layouts.backend.app')

@section('title', 'Create Category')

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
                            <li class="breadcrumb-item active">Add Debtor</li>
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
                                <h3 class="card-title">Add Debtor</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.debtors.store') }}" method="post">
                                @csrf

                                <div class="card-body">
                                    <div class="form-group col-lg-12">
                                        <label for="exampleDataList" class="form-label">Select Date</label>
                                        <input type="date" name="date" id="" class="form-control col-md-6" placeholder="Select Date">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleDataList" class="form-label">Customer Name</label>
                                        <input class="form-control" name="name" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                        <datalist id="datalistOptions" >
                                            <option value="" selected>Select a Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->full_name }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Amount</label>
                                                <input type="text" class="form-control" name="amount" value="{{ old('amount') }}" placeholder="Enter Amount Owing">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-md-right">Submit</button>
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