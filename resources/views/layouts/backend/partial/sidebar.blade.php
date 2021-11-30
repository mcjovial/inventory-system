<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="#" class="brand-link">
		<img src="{{ asset('assets/backend/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
		     style="opacity: .8">
		<span class="brand-text font-weight-light">CodeNet. Admin</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		{{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ asset('assets/backend/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">Saucegeek McJovial</a>
			</div>
		</div> --}}

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
					with font-awesome or any other icon font library -->
                    @if (Auth::user()->hasRole('admin'))
				<li class="nav-item has-treeview">
					<a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
						<i class="nav-icon fa fa-dashboard"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
                @endif
                @if (Auth::user()->hasRole('seller'))
				<li class="nav-item has-treeview">
					<a href="{{ route('admin.pos.index') }}" class="nav-link {{ Request::is('admin/pos') ? 'active' : '' }}">
						<i class="nav-icon fa fa-window-maximize"></i>
						<p>
							Point of Sales
						</p>
					</a>
				</li>
				@endif

				{{-- <li class="nav-item has-treeview {{ Request::is('admin/employee*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/employee*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-pie-chart"></i>
						<p>
							Employee
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.employee.create') }}" class="nav-link {{ Request::is('admin/employee/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Employee</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.employee.index') }}" class="nav-link {{ Request::is('admin/employee') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Employee</p>
							</a>
						</li>
					</ul>
				</li> --}}
				{{-- <li class="nav-item has-treeview {{ Request::is('admin/attendance*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/attendance*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-pie-chart"></i>
						<p>
							Attendance (EMP)
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.attendance.create') }}" class="nav-link {{ Request::is('admin/attendance/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Take Attendance</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.attendance.index') }}" class="nav-link {{ Request::is('admin/attendance') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Attendance</p>
							</a>
						</li>
					</ul>
				</li> --}}
				<li class="nav-item has-treeview {{ Request::is('admin/customer*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/customer*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-address-card"></i>
						<p>
							Member
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.customer.create') }}" class="nav-link {{ Request::is('admin/customer/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Member</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.customer.index') }}" class="nav-link {{ Request::is('admin/customer') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Memebers</p>
							</a>
						</li>
					</ul>
				</li>
				@if (Auth::user()->hasRole('admin'))
				<li class="nav-item has-treeview {{ Request::is('admin/supplier*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/supplier*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-pie-chart"></i>
						<p>
							Supplier
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.supplier.create') }}" class="nav-link {{ Request::is('admin/supplier/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Supplier</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.supplier.index') }}" class="nav-link {{ Request::is('admin/supplier') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Supplier</p>
							</a>
						</li>
					</ul>
				</li>

                <li class="nav-item has-treeview {{ Request::is('admin/supply*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/supply*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-cubes"></i>
						<p>
							Supply
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.supply.create') }}" class="nav-link {{ Request::is('admin/supply/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Supply</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.supply.index') }}" class="nav-link {{ Request::is('admin/supply') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Supplies</p>
							</a>
						</li>
					</ul>
				</li>
				{{-- <li class="nav-item has-treeview {{ Request::is('admin/advanced_salary*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/advanced_salary*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-pie-chart"></i>
						<p>
							Advanced Salary (EMP)
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.advanced_salary.create') }}" class="nav-link {{ Request::is('admin/advanced_salary/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Advanced Salary</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.advanced_salary.index') }}" class="nav-link {{ Request::is('admin/advanced_salary') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Advanced Salary</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item has-treeview {{ Request::is('admin/salary*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/salary*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-pie-chart"></i>
						<p>
							Salary (EMP)
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.salary.index') }}" class="nav-link {{ Request::is('admin/salary') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Pay Salary</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.salary.create') }}" class="nav-link {{ Request::is('admin/salary/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Paid Salary</p>
							</a>
						</li>
					</ul>
				</li> --}}

				<li class="nav-item has-treeview {{ Request::is('admin/category*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/category*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-pie-chart"></i>
						<p>
							Category
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.category.create') }}" class="nav-link {{ Request::is('admin/category/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Category</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.category.index') }}" class="nav-link {{ Request::is('admin/category') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Category</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview {{ Request::is('admin/product*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/product*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-glass"></i>
						<p>
							Product
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.product.create') }}" class="nav-link {{ Request::is('admin/product/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Product</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.product.index') }}" class="nav-link {{ Request::is('admin/product') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Products</p>
							</a>
						</li>
					</ul>
				</li>
                @endif
                @if (Auth::user()->hasRole('admin'))
				<li class="nav-item has-treeview {{ Request::is('admin/expense*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/expense*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-credit-card"></i>
						<p>
							Expense
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.expense.create') }}" class="nav-link {{ Request::is('admin/expense/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Expense</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.expense.today') }}" class="nav-link {{ Request::is('admin/expense-today') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Today Expense</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.expense.month') }}" class="nav-link {{ Request::is('admin/expense-month*') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Monthly Expense</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.expense.yearly') }}" class="nav-link {{ Request::is('admin/expense-yearly*') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Yearly Expense</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.expense.index') }}" class="nav-link {{ Request::is('admin/expense') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Expense</p>
							</a>
						</li>
					</ul>
				</li>
                @endif
                @if (Auth::user()->hasRole('seller'))
				<li class="nav-item has-treeview {{ Request::is('admin/order*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/order*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-money"></i>
						<p>
							Transactions
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.order.credit') }}" class="nav-link {{ Request::is('admin/order/credit') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Debtors</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.balance.index') }}" class="nav-link {{ Request::is('admin/order/balance') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Balance</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.order.to_balance') }}" class="nav-link {{ Request::is('admin/order/tobalance') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>To-Balance</p>
							</a>
						</li>
                        <li class="nav-item">
							<a href="{{ route('admin.order.pending') }}" class="nav-link {{ Request::is('admin/order/pending') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Pending </p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.order.approved') }}" class="nav-link {{ Request::is('admin/order/approved') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Approved </p>
							</a>
						</li>
					</ul>
				</li>
                @endif
                @if (Auth::user()->hasRole('admin'))
				<li class="nav-item has-treeview {{ Request::is('admin/sales*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/sales*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-pie-chart"></i>
						<p>
							Sales Report
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.sales.today') }}" class="nav-link {{ Request::is('admin/sales-today') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Today's Report</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.sales.monthly') }}" class="nav-link {{ Request::is('admin/sales-monthly*') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Monthly Report</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.sales.total') }}" class="nav-link {{ Request::is('admin/sales-total') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Total Sales</p>
							</a>
						</li>
					</ul>
				</li>
                @endif
                @if (Auth::user()->hasRole('secretary'))
                <li class="nav-item has-treeview {{ Request::is('admin/dues*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/dues*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-gg"></i>
						<p>
							Dues
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.year.index') }}" class="nav-link {{ Request::is('admin/year') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Year</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.dues.create') }}" class="nav-link {{ Request::is('admin/dues/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Pay</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.dues.index') }}" class="nav-link {{ Request::is('admin/dues') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Dues</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.employee.index') }}" class="nav-link {{ Request::is('admin/dues/report') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Dues Report</p>
							</a>
						</li>
					</ul>
				</li>
                @endif
                @if (Auth::user()->hasRole('admin'))
                <li class="nav-item has-treeview {{ Request::is('admin/users*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Users Manager
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::is('admin/users/index') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Users</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.role.create') }}" class="nav-link {{ Request::is('admin/role/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Roles</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.role.index') }}" class="nav-link {{ Request::is('admin/role/index') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Roles</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-header">MENU</li>
				<li class="nav-item has-treeview">
					<a href="{{ route('admin.setting.index') }}" class="nav-link {{ Request::is('admin/setting') ? 'active' : '' }}">
						<i class="nav-icon fa fa-server"></i>
						<p>
							Setting
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ route('logout') }}"
					   onclick="event.preventDefault();
					   document.getElementById('logout-form').submit();">
						<i class="nav-icon fa fa-sign-out"></i> Logout
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</li>
                @endif
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
