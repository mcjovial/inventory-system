@extends('layouts.backend.app')

@section('title', 'Setting')

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
                            <li class="breadcrumb-item active">Setting</li>
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
                                <h3 class="card-title">Setting</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.setting.update', $setting->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Club Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ $setting->name }}" placeholder="Enter Name">
                                            </div>
                                            <div class="form-group">
                                                <label>Club Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ $setting->email }}" placeholder="Enter Email">
                                            </div>
                                            <div class="form-group">
                                                <label>Club Mobile</label>
                                                <input type="text" class="form-control" name="mobile" value="{{ $setting->mobile }}" placeholder="Enter Mobile">
                                            </div>
                                            <div class="form-group">
                                                <label>Club Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{ $setting->phone }}" placeholder="Enter Phone">
                                            </div>
                                            <div class="form-group">
                                                <label>Club Address</label>
                                                <input type="text" class="form-control" name="address" value="{{ $setting->address }}" placeholder="Enter Address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Year</label>
                                                <input type="number" class="form-control" name="year" value="{{ $setting->year }}" placeholder="Enter Year for dues">
                                            </div>
                                            <div class="form-group">
                                                <label>Registration Fee</label>
                                                <input type="number" class="form-control" name="reg_fee" value="{{ $setting->reg_fee }}" placeholder="Enter Registration Fee">
                                            </div>
                                            <div class="form-group">
                                                <label>Annual Dues</label>
                                                <input type="number" class="form-control" name="annual" value="{{ $setting->annual }}" placeholder="Enter Annual Dues">
                                            </div>
                                            <div class="form-group">
                                                <label>Welfar Dues</label>
                                                <input type="number" class="form-control" name="welfare" value="{{ $setting->welfare }}" placeholder="Enter Welfare Dues">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputFile">Logo</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="logo" class="custom-file-input" id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                                <img width="80" height="70" class="img-rounded mt-3" src="{{ URL::asset('storage/setting/'. $setting->logo) }}" alt="{{ $setting->name }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-md-right">Update Setting</button>
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
