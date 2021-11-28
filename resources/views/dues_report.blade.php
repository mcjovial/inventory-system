@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">UNN Staff Club Members Dues Report</div>

                <div class="card-body">
                    {{-- You are logged in! --}}
                    <table id="example1" class="table table-bordered table-striped text-center table-responsive-xl">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Name</th>
                            @foreach($years as $year)
                                <th>{{ $year->number }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Serial</th>
                            <th>Name</th>
                            @foreach($years as $year)
                                <th>{{ $year->number }}</th>
                            @endforeach
                        </tr>
                        </tfoot>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->name }}</td>
                                    @foreach($years as $year)
                                        <td>
                                            @foreach ($customer->dues->where('year_id', $year->id) as $item)
                                                @if ($item->status)
                                                [<small><span>&#8358;</span>{{ $item->annual + $item->welfare }}]</small><span class="badge badge-success">Up-to-date</span>
                                                @else
                                                [<small><span>&#8358;</span>{{ $item->annual + $item->welfare }}] </small><span class="badge badge-danger">Not-up-to-date </span> [<small><span>&#8358;</span>{{ $item->debt }}]</small>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
