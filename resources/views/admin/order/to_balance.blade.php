@extends('layouts.backend.app')

@section('title', 'Orders To-Balance')

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
                            <li class="breadcrumb-item active">To-Balance</li>
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
                                <h3 class="card-title">TO-BALANCE LISTS</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center table-responsive">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Seller</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Date</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Debt</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Seller</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Debt</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($credits as $key => $order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $order->seller }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ $order->customer_phone }}</td>
                                            <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                            <td>{{ $order->total_products }}</td>
                                            <td><span>&#8358;</span>{{ $order->total }}</td>
                                            <td><span>&#8358;</span>{{ $order->debt }}</td>
                                            <td>{{ $order->payment_status }}</td>
                                            <td><span class="badge badge-warning">{{ $order->order_status }}</span></td>

                                            <td>
                                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-success" title="Show">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('admin.order.payout', $order->id) }}" class="btn btn-info" title="Balance">
                                                    <i class="fa fa-balance-scale" aria-hidden="true"></i>
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
