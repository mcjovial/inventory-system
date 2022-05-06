@extends('layouts.backend.app')

@section('title', 'Launch')

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
                            <li class="breadcrumb-item active">Launch</li>
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
                    <div class="col-md-5">
                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">POS</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center table-responsive-l">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Add To Cart</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Add To Cart</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($drinks as $key => $drink)
                                        <tr>
                                            <form action="{{ route('admin.launch.cart_store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $drink->id }}">
                                                <input type="hidden" name="name" value="{{ $drink->name }}">
                                                <input type="hidden" name="cartons" value="1">
                                                <input type="hidden" name="price" value="{{ $drink->sell_price_bottle }}">

                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $drink->name }}</td>
                                                <td> <span>&#8358;</span> {{ number_format($drink->sell_price_bottle, 2) }}</td>
                                                <td>
                                                    <button type="submit" class="btn btn-sm btn-success px-2" title="Add to cart">
                                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                            </form>
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
                    <div class="col-md-7">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fa fa-info"></i>
                                    Shopping Lists
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if($cart_products->count() < 1)
                                    <div class="alert alert-danger">
                                        No Product Added
                                    </div>
                                @else
                                    <table class="table table-bordered table-striped text-center mb-3 table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Name</th>
                                                <th>Number of Cartons</th>
                                                <th>Quantity Per Launch</th>
                                                <th>Price</th>
                                                <th>Sub Total</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cart_products as $product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $product->name }}</td>

                                                    <form action="{{ route('admin.launch.cart_update', $product->id) }}" method="post">
                                                        @csrf
                                                        {{-- @method('PUT') --}}
                                                        <td>
                                                            <input type="number" name="cartons" class="form-control" value="{{ $product->cartons }}">
                                                        </td>
                                                        <td>{{ $product->product->launch_cartons }}</td>
                                                        <td> <span>&#8358;</span> {{ $price = number_format($product->price, 2) }}</td>
                                                        <td> <span>&#8358;</span> {{ number_format($product->total, 2) }}</td>
                                                        <td>
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                    </form>

                                                    <td>
                                                        <button class="btn btn-danger" type="button" onclick="deleteItem({{ $product->id }})">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.cart.destroy', $product->id) }}" method="post"
                                                            style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif

                                <div class="alert alert-info">
                                    <p>Quantity : {{ $cart->sum('quantity') }}</p>
                                    <p>Sub Total :  <span>&#8358;</span> {{ $cart->sum('total') }}</p>
                                    Tax :  <span>&#8358;</span> {{ 0 }}
                                </div>
                                <div class="alert alert-success">
                                    Total :  <span>&#8358;</span> {{ $cart->sum('total') }}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card">
                            <form action="{{ route('admin.launch.invoice') }}" method="post">
                                @csrf
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Customer
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <input type="text" name="order_id" value="{{$order->order_date ? $order->id : ''}}" hidden>

                                    <div class="form-group col">
                                        <label for="inputState">Payment Method</label>
                                        <select name="pay" class="form-control" required >
                                            <option value="" disabled selected>Choose a Payment Method</option>
                                            <option value="cash">Cash</option>
                                            <option value="transfer">Transfer</option>
                                        </select>
                                    </div>
                                    <div class="form-group col">
                                        <label for="exampleDataList" class="form-label">Customer Name</label>
                                        <input class="form-control" name="name" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                        <datalist id="datalistOptions" >
                                            <option value="" selected>Select a Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->full_name }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <span>
                                        <button type="submit" class="btn btn-sm btn-info float-md-right ml-3">Create Invoice</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
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
