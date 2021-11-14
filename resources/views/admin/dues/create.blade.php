@extends('layouts.backend.app')

@section('title', 'Create Dues')

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
                                <h3 class="card-title">Pay Dues</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.dues.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col">
                                            <div class="form-group">
                                                <label>Member</label>
                                                <select name="customer_id" class="form-control">
                                                    <option value="" disabled selected>Select a Member</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }} <div class="float-right text-danger">[NIN]: {{ $customer->nin }}</div> </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Year</label>
                                                <input type="number" class="form-control" name="year" value="{{ old('year') }}" placeholder="{{ $settings->year }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Annual Dues</label>
                                                <input type="number" class="form-control" name="annual" value="{{ old('annual') }}" placeholder="{{ $settings->annual }}">
                                            </div>
                                            <div class="form-group">
                                                <label>welfare Dues</label>
                                                <input type="number" class="form-control" name="welfare" value="{{ old('welfare') }}" placeholder="{{ $settings->welfare }}">
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
