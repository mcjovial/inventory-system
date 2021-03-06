@extends('layouts.backend.app')

@section('title', 'Approved Orders')

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
                            <li class="breadcrumb-item active">Confirmed Transactions</li>
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
                        <div class="form-group">
                            <a href="{{ route('admin.debtors.create') }}" class="btn btn-primary">Add Debtor</a>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">CONFIRMED TRANSACTION LISTS</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center table-responsive-l">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Date</th>
                                        <th>Seller</th>
                                        <th>Quantity</th>
                                        <th>Total Sale</th>
                                        <th>Debt</th>
                                        <th>Income</th>
                                        <th>Exchange</th>
                                        <th>To Balance</th>
                                        <th>Launch</th>
                                        <th>Order Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Date</th>
                                        <th>Seller</th>
                                        <th>Quantity</th>
                                        <th>Total Sale</th>
                                        <th>Debt</th>
                                        <th>Income</th>
                                        <th>Exchange</th>
                                        <th>To Balance</th>
                                        <th>Launch</th>
                                        <th>Order Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($approveds as $key => $order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                            <td>{{ $order->seller }}</td>
                                            <td>{{ $order->total_products }}</td>
                                            <td><span>&#8358;</span>{{ $order->total }}</td>
                                            <td><span>&#8358;</span>{{ $order->debt }}</td>
                                            <td><span>&#8358;</span>{{ $order->pay }}</td>
                                            <td><span>&#8358;</span>{{ $order->exchange }}</td>
                                            <td><span>&#8358;</span>{{ $order->to_balance }}</td>
                                            <td><span>&#8358;</span>{{ $order->launch }}</td>
                                            {{-- @if ($order->launch)
                                            <td>{{ $order->payment_status  }} <small>[Launch]</small></td>
                                            @elseif ($order->bulk)
                                                <td>{{ $order->payment_status  }} <small>[Bulk]</small></td>
                                            @else
                                                <td>{{ $order->payment_status  }}</td>
                                            @endif --}}
                                            <td><span class="badge badge-success">{{ $order->order_status }}</span></td>

                                            <td>
                                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-success" title="Show sales detail">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('admin.transfer.create.id', $order->id) }}" class="btn btn-primary" title="Add Transfer">
                                                    <i class="fa fa-share" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('admin.debtors.create.id', $order->id) }}" class="btn btn-info" title="Add debtor">
                                                    <i class="fa fa-money" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('admin.launch.create.id', $order->id) }}" class="btn btn-info" title="Add launch">
                                                    <i class="fa fa-rocket" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('admin.exchange.create', $order->id) }}" class="btn btn-warning" title="Add exchange">
                                                    <i class="fa fa-random" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('admin.create.flat', $order->id) }}" class="btn btn-secondary" title="Flat">
                                                    Flat
                                                </a>
                                                
                                                @if (Auth::user()->hasRole('admin'))
                                                <button class="btn btn-danger" type="button" onclick="deleteItem({{ $order->id }})" title="Delete">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <form id="delete-form-{{ $order->id }}" action="{{ route('admin.order.destroy', $order->id) }}" method="post"
                                                    style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif

                                            </td>
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
