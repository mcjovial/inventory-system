@extends('layouts.backend.app')

@section('title', 'Update Member')

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
                            <li class="breadcrumb-item active">Update Member</li>
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
                                <h3 class="card-title">Update Member</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.customer.update', $customer->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" class="form-control" name="title" value="{{ $customer->title }}" placeholder="Enter Title: Prof, Dr, Mr, Mrs or Miss">
                                            </div>
                                            <div class="form-group">
                                                <label>Surname</label>
                                                <input type="text" class="form-control" name="sur_name" value="{{ $customer->sur_name }}" placeholder="Enter Surname">
                                            </div>
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="first_name" value="{{ $customer->first_name }}" placeholder="Enter First Name">
                                            </div>
                                            <div class="form-group">
                                                <label>Other Name</label>
                                                <input type="text" class="form-control" name="other_name" value="{{ $customer->other_name }}" placeholder="Enter Other Name">
                                            </div>
                                            <div class="form-group">
                                                <label>Birth Month</label>
                                                <select name="b_month" class="form-control" required>
                                                    <option value="" disabled selected>Select a Month</option>
                                                    <option value="january" {{ $customer->b_month == 'january' ? 'selected' : '' }}>January</option>
                                                    <option value="february" {{ $customer->b_month == 'february' ? 'selected' : '' }}>February</option>
                                                    <option value="march" {{ $customer->b_month == 'march' ? 'selected' : '' }}>March</option>
                                                    <option value="april" {{ $customer->b_month == 'april' ? 'selected' : '' }}>April</option>
                                                    <option value="may" {{ $customer->b_month == 'may' ? 'selected' : '' }}>May</option>
                                                    <option value="june" {{ $customer->b_month == 'june' ? 'selected' : '' }}>June</option>
                                                    <option value="july" {{ $customer->b_month == 'july' ? 'selected' : '' }}>July</option>
                                                    <option value="august" {{ $customer->b_month == 'august' ? 'selected' : '' }}>August</option>
                                                    <option value="september" {{ $customer->b_month == 'september' ? 'selected' : '' }}>September</option>
                                                    <option value="october" {{ $customer->b_month == 'october' ? 'selected' : '' }}>October</option>
                                                    <option value="november" {{ $customer->b_month == 'november' ? 'selected' : '' }}>November</option>
                                                    <option value="december" {{ $customer->b_month == 'december' ? 'selected' : '' }}>December</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Birth day</label>
                                                <input type="number" class="form-control" name="b_day" value="{{ $customer->b_day }}" placeholder="Enter Birth day" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ $customer->email }}"  placeholder="Enter Email">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="number" class="form-control" name="phone" value="{{ $customer->phone }}" placeholder="Enter Phone">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Place of Work</label>
                                                <input type="text" class="form-control" name="pow" value="{{ $customer->pow }}" placeholder="Enter Place of work or department" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address" value="{{ $customer->address }}" placeholder="Enter Address">
                                            </div>
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select name="type" class="form-control" required>
                                                    <option value="member" {{ $customer->type == 'member' ? 'selected' : '' }}>Member</option>
                                                    <option value="asso-member" {{ $customer->type == 'asso-member' ? 'selected' : '' }}>Associate Member</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>State</label>
                                                <select name="state" class="form-control" required>
                                                    <option value="active" {{ $customer->state == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="suspended" {{ $customer->state == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                                    <option value="relocated" {{ $customer->state == 'relocated' ? 'selected' : '' }}>Relocated</option>
                                                    <option value="withdrawn" {{ $customer->state == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                                                    <option value="deceased" {{ $customer->state == 'deceased' ? 'selected' : '' }}>Deceased</option>
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
                                                <p class="mt-2">
                                                    <img width="50" height="50" src="{{ URL::asset("storage/customer/".$customer->photo) }}" alt="{{ $customer->full_name }}">
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label>Registration Fee <span class="text-danger"> <span>&#8358;</span>[{{ $customer->debt > 0 ? $customer->debt : '0' }}]</span></label>
                                                <input type="number" class="form-control" name="reg_fee" value="{{ $settings->reg_fee - $customer->debt }}" placeholder="{{ $settings->reg_fee }}">
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
