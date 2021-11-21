@extends('layouts.backend.app')

@section('title', 'Edit Dues')

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
                            <li class="breadcrumb-item active">Dues</li>
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
                                <h3 class="card-title">Edit Dues</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.dues.update', $due->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col">
                                            <div class="form-group">
                                                <label>Member</label>
                                                <input type="number" class="form-control" name="" value="{{ $due->customer->name }}" placeholder="{{ $due->customer->name }}">
                                                <input type="number" class="form-control" name="customer_id" value="{{ $due->customer->id }}" hidden>
                                            </div>
                                            <div class="form-group">
                                                <label>Year</label>
                                                <input type="number" class="form-control" name="" value="{{ $due->year->number }}" placeholder="{{ $due->year->number }}">
                                                <input type="number" class="form-control" name="year_id" value="{{ $due->year->id }}" hidden>
                                            </div>
                                            <div class="form-group">
                                                <label>Annual Dues <span class="text-danger"> <span>&#8358;</span>[{{ $settings->annual - $due->annual > 0 ? $settings->annual - $due->annual : '0' }}]</span></label>
                                                <input type="number" class="form-control" name="annual" value="{{ $due->annual }}" placeholder="{{ $settings->annual }}">
                                            </div>
                                            <div class="form-group">
                                                <label>welfare Dues <span class="text-danger"> <span>&#8358;</span>[{{ $settings->welfare - $due->welfare > 0 ? $settings->welfare - $due->welfare : '0' }}]</span></label>
                                                <input type="number" class="form-control" name="welfare" value="{{ $due->welfare }}" placeholder="{{ $settings->welfare }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-md-right">Pay</button>
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
