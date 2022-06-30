<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex" />
    <meta name="googlebot" content="noindex">
    <meta name="googlebot-news" content="nosnippet">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('cdn/fontawesome-free/css/all.min.css')}}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('cdn/css/adminlte.min.css')}}" />
    @yield('css-tambahan')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info">Profile</button>
                        <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"
                            aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-key mr-2"></i>Change Password</a>
                            <div class="dropdown-item"><input type="checkbox" name="mode" class="mr-1"><span>Dark
                                    Mode</span></div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="fas fa-unlock mr-2"></i>Log Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('cdn/img/logo.png') }}" alt="Dashboard" class="brand-image elevation-2" />
                <span class="brand-text font-weight-light">Dashboard</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                @include('layouts.dashboard.menu')
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer text-center">
            <!-- Default to the left -->
            <strong>Copyright &copy; 2022
                <a href="https://moko.co.id/">MOKO GARMENT INDONESIA</a>.</strong>
            All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <style>
            td, th {
        font-size: 0.9em !important;
        }
        .table td, .table th {
            padding: 0.45rem;
        }
        
        .dataTables_info , div.dataTables_wrapper div.dataTables_length label, div.dataTables_wrapper div.dataTables_filter label, footer.main-footer.text-center, li.nav-item, li.breadcrumb-item{
            font-size: small;
        }
        .page-link {
            padding: 0.5em 0.75em;
            line-height: .7;
            font-size: small;
        }
        .form-control-sm {
            height: calc(1.8125rem );
        }
        .content-header {
            padding: 5px 0.5em;
        }
        .form-control-sidebar {
            height: calc(2.15rem);
        }
        .btn.btn-sidebar{
        padding: 0.25rem 0.75rem;
        }
        table.dataTable{
            border-collapse: collapse !important;
        }
        .table-bordered {
        border: none; 
        }
        table.table-bordered.dataTable th, table.table-bordered.dataTable td {
            border-left-width: 1px;
            border-bottom-width: 1px !important;
        }
       
    </style>


    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{asset('cdn/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('cdn/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('cdn/js/adminlte.min.js')}}"></script>
    <script src="{{asset('cdn/js/script.js')}}"></script>
    {{-- tambahan --}}
    @yield('js-tambahan')
</body>

</html>
