@extends('layouts.backend.app')

@section('title', 'Update Customer')

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
                            <li class="breadcrumb-item active">Update Customer</li>
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
                                <h3 class="card-title">Update Customer</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.customer.update', $customer->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ $customer->name }}" placeholder="Enter Name">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ $customer->email }}"  placeholder="Enter Email">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{ $customer->phone }}" placeholder="Enter Phone">
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address" value="{{ $customer->address }}" placeholder="Enter Address">
                                            </div>
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="city" value="{{ $customer->city }}" placeholder="Enter City">
                                            </div>
                                            <div class="form-group">
                                                <label>NIN</label>
                                                <input type="text" class="form-control" name="nin" value="{{ $customer->nin }}" placeholder="Enter Your NIN">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Photo</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                                <p class="mt-2">
                                                    <img width="50" height="50" src="{{ URL::asset("storage/customer/".$customer->photo) }}" alt="{{ $customer->name }}">
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label>Account Holder</label>
                                                <input type="text" class="form-control" name="account_holder" value="{{ $customer->account_holder }}" placeholder="Enter Account Holder">
                                            </div>
                                            <div class="form-group">
                                                <label>Account Number</label>
                                                <input type="text" class="form-control" name="account_number" value="{{ $customer->account_number }}" placeholder="Enter Account Number">
                                            </div>
                                            <div class="form-group">
                                                <label>Bank Name</label>
                                                <input type="text" class="form-control" name="bank_name" value="{{ $customer->bank_name }}" placeholder="Enter Bank Name">
                                            </div>
                                            <div class="form-group">
                                                <label>Registration Fee</label>
                                                <input type="number" class="form-control" name="reg_fee" value="{{ $customer->dues->reg_fee }}" placeholder="Enter Registration Fee">
                                            </div>
                                            <div class="form-group">
                                                <label>Annual Dues</label>
                                                <input type="number" class="form-control" name="annual" value="{{ $customer->dues->annual }}" placeholder="Enter Annual Dues">
                                            </div>
                                            <div class="form-group">
                                                <label>welfare Dues</label>
                                                <input type="number" class="form-control" name="welfare" value="{{ $customer->dues->welfare }}" placeholder="Enter Welfare Dues">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-md-right">Update Customer</button>
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
