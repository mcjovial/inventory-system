@extends('layouts.backend.app')

@section('title', 'Register Flat Drink')

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
                            <li class="breadcrumb-item active">Register Flat</li>
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
                                <h3 class="card-title">Register Flat Drink</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.store.flat') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            {{-- <div class="form-group">
                                                <label for="exampleDataList" class="form-label">Select Custormer</label>
                                                <input class="form-control" name="name" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                                <datalist id="datalistOptions" >
                                                    <option value="" selected>Select Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->sur_name.' '.$customer->first_name.' '.$customer->other_name }}">
                                                    @endforeach
                                                </datalist>
                                            </div> --}}
                                            <input type="number" name="order_id" value="{{ $order->id }}" hidden>
                                            <div class="form-group">
                                                <label>Select Drink</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <select name="product_id" class="form-control" required>
                                                    <option value="" disabled>Select Drink</option>
                                                    @foreach($drinks as $drink)
                                                        <option value="{{ $drink->product->id }}">{{ $drink->product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="number" class="form-control" name="quantity" value="{{ old('quantity') }}" placeholder="Enter quantity" required>
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
