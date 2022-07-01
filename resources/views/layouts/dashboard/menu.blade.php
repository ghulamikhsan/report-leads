<div class="form-inline mt-2">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the  -->
        @can('menu-user')
            @if (Auth::user()->id == 1)
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ Request::is('detail') ? 'active' : '' }}">
                        <i class="fas fa-th-large nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::segment(1) === 'dashboard' ? 'menu-is-opening menu-open' : null }}">
                    <a href="#" class="nav-link {{ Request::segment(2) === 'course' ? 'active' : null }}">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            Permissions Access
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}"
                                class="nav-link {{ Request::is('dashboard/users') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}"
                                class="nav-link {{ Request::is('dashboard/roles') ? 'active' : null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Role Controll</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permissions.index') }}"
                                class="nav-link {{ Request::is('dashboard/permissions') ? 'active' : null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permissions Controll</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Request::segment(1) === 'dashboard' ? 'menu-is-opening menu-open' : null }}">
                    <a href="#" class="nav-link {{ Request::segment(2) === 'course' ? 'active' : null }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('detail.index') }}"
                                class="nav-link {{ Request::is('master/reports') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Detail Laporan Penjualan Per Marketing</p>
                            </a>
                            <a href="{{ route('detailtgl') }}"
                                class="nav-link {{ Request::is('master/month-reports') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Detail Laporan Penjualan Per Tanggal</p>
                            </a>
                            <a href="{{ route('detailcust') }}"
                                class="nav-link {{ Request::is('master/month-reports') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Customer</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->id != 1)
                <li class="nav-item">
                    <a href="{{ route('master.index') }}"
                        class="nav-link {{ Request::is('detail') ? 'active' : '' }}">
                        <i class="fas fa-tasks nav-icon"></i>
                        <p>Laporan Penjualan Marketing</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('detailbln') }}"
                        class="nav-link {{ Request::is('master/month-reports') ? 'active' : '' }}">
                        <i class="fas fa-calendar-week nav-icon"></i>
                        <p>Detail Laporan Penjualan Per Bulan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('detailthn') }}"
                        class="nav-link {{ Request::is('master/month-reports') ? 'active' : '' }}">
                        <i class="fas fa-calendar-day nav-icon"></i>
                        <p>Detail Laporan Penjualan Per Tahun</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}"
                        class="nav-link {{ Request::is('laporan') ? 'active' : '' }}">
                        <i class="fas fa-store nav-icon"></i>
                        <p>Tambah Laporan Penjualan</p>
                    </a>
                </li>
                <li class="nav-item">
                    {{-- <a href="{{route('customers.index')}}" class="nav-link {{ Request::is('menu/customers') ? 'active' : '' }}"> --}}
                    <a href="{{ route('customer.index') }}"
                        class="nav-link {{ Request::is('customer') ? 'active' : '' }}">
                        <i class="fas fa-user-friends nav-icon"></i>
                        <p>Tambah Customer</p>
                    </a>
                </li>
            @endif
        @endcan
    </ul>
</nav>
<!-- /.sidebar-menu -->
