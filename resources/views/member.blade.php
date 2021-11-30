@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('member_search') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">
                            Member Name Search
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleDataList" class="form-label">Search  Your Name To Edit Info</label>
                            <input class="form-control" name="name" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                            <datalist id="datalistOptions" >
                                <option value="" selected>Select Your Name & Submit</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->sur_name.' '.$customer->first_name.' '.$customer->other_name }}">
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span>
                            <button type="submit" class="btn btn-sm btn-info">Submit</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
