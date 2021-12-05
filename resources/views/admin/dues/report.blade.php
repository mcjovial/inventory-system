@extends('layouts.backend.app')

@section('title', 'Dues Report')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dues Report</li>
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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    DUES REPORT
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center table-responsive-l">
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
                                    {{-- {{ dd($customers[0]->dues->where('year', '2021')->first()->welfare)}}m --}}
                                    <tbody>
                                        @foreach($customers as $customer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $customer->title.'. '.$customer->full_name }}</td>
                                                @foreach($years as $year)
                                                    <td>
                                                        {{-- @if(!$year->dues->where('customer_id', $customer->id)->first()->status)
                                                            <span class="badge badge-danger">Not-up-to-date <span><strong><span>&#8358;</span>{{ $year->dues->where('customer_id', $customer->id)->first()->debt }}]</strong></span></span>
                                                        @else
                                                            <span class="badge badge-success">Up-to-date</span>
                                                        @endif --}}
                                                        {{-- @php
                                                            $status = $customer->dues->where('year_id', $year->id)->first();
                                                            $array = json_decode(json_encode($status), true);
                                                       @endphp
                                                        
                                                        {{ $status['status'] }} --}}
                                                        {{-- {{$customer->dues->where('year_id', $year->id)->first()}} --}}
                                                        @foreach ($customer->dues->where('year_id', $year->id) as $item)
                                                            {{-- {{$item->status}} --}}
                                                            @if ($item->status)
                                                            [<small><span>&#8358;</span>{{ $item->annual + $item->welfare }}]</small><span class="badge badge-success">Up-to-date</span>
                                                            @else
                                                            [<small><span>&#8358;</span>{{ $item->annual + $item->welfare }}] </small><span class="badge badge-danger">Not-up-to-date </span> [<small><span>&#8358;</span>{{ $item->debt }}]</small>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                @endforeach
                                                {{-- <td>{{ \Carbon\Carbon::parse($due->welfare_date)->toFormattedDateString() }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    </div> <!-- Content Wrapper end -->
@endsection




@push('js')

    <!-- DataTables -->
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/backend/plugins/fastclick/fastclick.js') }}"></script>

    <!-- Sweet Alert Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script>


    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>


    <script type="text/javascript">
        function deleteItem(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
