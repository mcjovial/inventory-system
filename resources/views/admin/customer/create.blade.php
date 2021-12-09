@extends('layouts.backend.app')

@section('title', 'Create Customer')

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
                            <li class="breadcrumb-item active">Create Member</li>
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
                                <h3 class="card-title">Create Member</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.customer.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Enter Title: Prof, Dr, Mr, Mrs or Miss" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Surname</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="text" class="form-control" name="sur_name" value="{{ old('sur_name') }}" placeholder="Enter Surname" required>
                                            </div>
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="Enter First Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Other Names</label>
                                                <input type="text" class="form-control" name="other_name" value="{{ old('other_name') }}" placeholder="Enter Other Name">
                                            </div>
                                            <div class="form-group">
                                                <label>Birth Month</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <select name="b_month" class="form-control" required>
                                                    <option value="" disabled selected>Select a Month</option>
                                                    <option value="january">January</option>
                                                    <option value="february">February</option>
                                                    <option value="march">March</option>
                                                    <option value="april">April</option>
                                                    <option value="may">May</option>
                                                    <option value="june">June</option>
                                                    <option value="july">July</option>
                                                    <option value="august">August</option>
                                                    <option value="september">September</option>
                                                    <option value="october">October</option>
                                                    <option value="november">November</option>
                                                    <option value="december">December</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Birth day</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="number" class="form-control" name="b_day" value="{{ old('b_day') }}" placeholder="Enter Birth day" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Email" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone"required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Place of Work</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="text" class="form-control" name="pow" value="{{ old('pow') }}" placeholder="Enter Place of work or department" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Enter Address" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Type</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <select name="type" class="form-control" required>
                                                    <option value="" disabled selected>Select Membership Type</option>
                                                    <option value="member">Member</option>
                                                    <option value="asso-member">Associate Member</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>State</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <select name="state" class="form-control" required>
                                                    <option value="" disabled>Select Member's state</option>
                                                    <option value="active" selected>Active</option>
                                                    <option value="suspended">Suspended</option>
                                                    <option value="relocated">Relocated</option>
                                                    <option value="withdrawn">Withdrawn</option>
                                                    <option value="deceased">Deceased</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputFile">Photo</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Registration Fee</label>
                                                <small class="text-danger">
                                                    (required *)
                                                </small>
                                                <input type="number" class="form-control" name="reg_fee" value="{{ old('reg_fee') }}" placeholder="{{ $settings->reg_fee }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-md-right">Create Customer</button>
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
