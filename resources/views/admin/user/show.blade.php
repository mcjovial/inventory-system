@extends('layouts.backend.app')

@section('title', 'Show Product')

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
                            <li class="breadcrumb-item active">Show Product</li>
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
                                <h3 class="card-title">Show Product</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->


                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <p>{{ $product->name }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputFile">Image</label>
                                                <p>
                                                    <img width="50" height="50" src="{{ URL::asset("storage/product/".$product->image) }}" alt="{{ $product->name }}">
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label>Category</label>
                                                <p>{{ $product->category->name }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <p>{{ $product->supplier->name }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label>Stock Units</label>
                                                <p>{{ $product->stock }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label>Launch Qty</label>
                                                <p>{{ $product->launch_cartons }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Buying Date</label>
                                                <p>{{ $product->buying_date->toFormattedDateString() }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label>Expire Date</label>
                                                <p>{{ $product->expire_date->toFormattedDateString() }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label>Cost Price Per Pack</label>
                                                <p><span>&#8358;</span>{{ number_format($product->cost_price_pack, 2) }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label>Cost Price Per Bottle</label>
                                                <p><span>&#8358;</span>{{ number_format($product->cost_price_bottle, 2) }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label>Selling Price</label>
                                                <p><span>&#8358;</span>{{ number_format($product->sell_price_bottle, 2) }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label>Launching Price</label>
                                                <p><span>&#8358;</span>{{ number_format($product->launch_price, 2) }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label>Number of Bottles</label>
                                                <p><span>&#8358;</span>{{ number_format($product->bottles_per_pack, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

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
