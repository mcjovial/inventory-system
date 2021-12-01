@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update {{ $customer->full_name }}</h3>
                </div>
                <!-- /.card-header -->

                <!-- form start -->
                <form role="form" action="{{ route('member_update', $customer->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Surname</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <input type="text" class="form-control" name="sur_name" value="{{ $customer->sur_name }}" placeholder="Enter Surname">
                                </div>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <input type="text" class="form-control" name="first_name" value="{{ $customer->first_name }}" placeholder="Enter First Name">
                                </div>
                                <div class="form-group">
                                    <label>Other Name</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <input type="text" class="form-control" name="other_name" value="{{ $customer->other_name }}" placeholder="Enter Other Name">
                                </div>
                                <div class="form-group">
                                    <label>Birth Month</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
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
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <input type="number" class="form-control" name="b_day" value="{{ $customer->b_day }}" placeholder="Enter Birth day" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <input type="email" class="form-control" name="email" value="{{ $customer->email }}"  placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <input type="number" class="form-control" name="phone" value="{{ $customer->phone }}" placeholder="Enter Phone">
                                </div>
                                <div class="form-group">
                                    <label>Place of Work</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <input type="text" class="form-control" name="pow" value="{{ $customer->pow }}" placeholder="Enter Place of work or department" required>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <input type="text" class="form-control" name="address" value="{{ $customer->address }}" placeholder="Enter Address">
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <select name="type" class="form-control" required>
                                        <option value="member" {{ $customer->type == 'member' ? 'selected' : '' }}>Member</option>
                                        <option value="asso-member" {{ $customer->type == 'asso-member' ? 'selected' : '' }}>Associate Member</option>
                                    </select>
                                </div>
                                {{-- <div class="form-group">
                                    <label>State</label>
                                    <small class="text-danger">
                                        (required *)
                                    </small>
                                    <select name="state" class="form-control" required>
                                        <option value="active" {{ $customer->state == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="suspended" {{ $customer->state == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        <option value="relocated" {{ $customer->state == 'relocated' ? 'selected' : '' }}>Relocated</option>
                                        <option value="withdrawn" {{ $customer->state == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                                        <option value="deceased" {{ $customer->state == 'deceased' ? 'selected' : '' }}>Deceased</option>
                                    </select>
                                </div> --}}
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
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-md-right">Update Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
