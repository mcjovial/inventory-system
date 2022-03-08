@extends('layouts.backend.app')

@section('title', 'Pos')

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
                            <li class="breadcrumb-item active">Exchange</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5">
                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Drinks Out</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center table-responsive">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock Units</th>
                                        <th>Add To Cart</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock Units</th>
                                        <th>Add To Cart</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($drinks as $key => $drink)
                                        <tr>
                                            <form action="{{ route('admin.exchange.out.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $drink->id }}">
                                                <input type="hidden" name="name" value="{{ $drink->name }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="price" value="{{ $drink->sell_price_bottle }}">

                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $drink->name }}</td>
                                                <td> <span>&#8358;</span> {{ number_format($drink->sell_price_bottle, 2) }}</td>
                                                <td>{{ $drink->stock }}</td>
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
                    <!-- left column -->
                    <div class="col-md-7">

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fa fa-info"></i>
                                    Exchange Out
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if($cart_out->count() < 1)
                                    <div class="alert alert-danger">
                                        No Product Added
                                    </div>
                                @else
                                    <table class="table table-bordered table-striped text-center mb-3 table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Sub Total</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cart_out as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $product->name }}</td>

                                                <form action="{{ route('admin.exchange.out.update', $product->id) }}" method="post">
                                                    @csrf
                                                    {{-- @method('PUT') --}}
                                                    <td>
                                                        <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}">
                                                    </td>
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
                                                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.exchange.out.destroy', $product->id) }}"
                                                        style="display:none;">
                                                        @csrf
                                                        {{-- @method('DELETE') --}}
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif

                                <div class="alert alert-info">
                                    <p>Quantity : {{ $cart_out->sum('quantity') }}</p>
                                    <p>Sub Total :  <span>&#8358;</span> {{ $cart_out->sum('total') }}</p>
                                    Tax :  <span>&#8358;</span> {{ 0 }}
                                </div>
                                <div class="alert alert-success">
                                    Total :  <span>&#8358;</span> {{ $cart_out->sum('total') }}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                </div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-5">
                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Drinks In</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example5" class="table table-bordered table-striped text-center table-responsive">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock Units</th>
                                        <th>Add To Cart</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock Units</th>
                                        <th>Add To Cart</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($drinks as $key => $drink)
                                        <tr>
                                            <form action="{{ route('admin.exchange.in.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $drink->id }}">
                                                <input type="hidden" name="name" value="{{ $drink->name }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="price" value="{{ $drink->sell_price_bottle }}">

                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $drink->name }}</td>
                                                <td> <span>&#8358;</span> {{ number_format($drink->sell_price_bottle, 2) }}</td>
                                                <td>{{ $drink->stock }}</td>
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
                    <div class="col-md-7">

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fa fa-info"></i>
                                    Exchange In
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if($cart_in->count() < 1)
                                    <div class="alert alert-danger">
                                        No Product Added
                                    </div>
                                @else
                                    <table class="table table-bordered table-striped text-center mb-3 table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Sub Total</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cart_in as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $product->name }}</td>

                                                <form action="{{ route('admin.exchange.in.update', $product->id) }}" method="post">
                                                    @csrf
                                                    {{-- @method('PUT') --}}
                                                    <td>
                                                        <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}">
                                                    </td>
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
                                                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.exchange.in.destroy', $product->id) }}"
                                                        style="display:none;">
                                                        @csrf
                                                        {{-- @method('DELETE') --}}
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif

                                <div class="alert alert-info">
                                    <p>Quantity : {{ $cart_in->sum('quantity') }}</p>
                                    <p>Sub Total :  <span>&#8358;</span> {{ $cart_in->sum('total') }}</p>
                                    Tax :  <span>&#8358;</span> {{ 0 }}
                                </div>
                                <div class="alert alert-success">
                                    Total :  <span>&#8358;</span> {{ $cart_in->sum('total') }}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card">
                            <form action="{{ route('admin.exchange.invoice') }}" method="post">
                                @csrf
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Customer
                                    </h3>
                                </div>

                                <div class="card-body">
                                    <div class="form-group col">
                                        <label for="exampleDataList" class="form-label">Select Date</label>
                                        <input type="date" name="date" value="{{$order->order_date}}" class="form-control col-md-6" placeholder="Select Date">
                                    </div>

                                    <div class="form-group">
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
                                        <button type="submit" class="btn btn-sm btn-info float-md-right ml-3">Submit</button>
                                        {{-- <a href="{{ route('admin.customer.create') }}" class="btn btn-sm btn-primary float-md-right">Add New</a> --}}
                                    </span>
                                </div>
                            </form>
                        </div>
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

<script>
    $(function () {
        $("#example5").DataTable();
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
